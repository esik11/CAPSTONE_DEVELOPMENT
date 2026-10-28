<?php

$file = 'resources/views/doctor/consultations/summary.blade.php';
$content = file_get_contents($file);
$lines = explode("\n", $content);

$stack = [];
$errors = [];

foreach ($lines as $lineNum => $line) {
    $actualLineNum = $lineNum + 1;

    // Remove inline @if...@endif patterns to avoid false positives
    $cleanedLine = preg_replace('/@if\b.*?@endif/', '', $line);

    // Check for @if (that's not inline)
    if (preg_match('/@if\b/', $cleanedLine)) {
        $stack[] = ['type' => 'if', 'line' => $actualLineNum];
    }

    // Check for @foreach
    if (preg_match('/@foreach\b/', $line)) {
        $stack[] = ['type' => 'foreach', 'line' => $actualLineNum];
    }

    // Check for @forelse
    if (preg_match('/@forelse\b/', $line)) {
        $stack[] = ['type' => 'forelse', 'line' => $actualLineNum];
    }

    // Check for @php (not inline)
    if (preg_match('/@php\b/', $line) && ! preg_match('/@endphp/', $line)) {
        $stack[] = ['type' => 'php', 'line' => $actualLineNum];
    }

    // Check for @endif (that's not inline)
    if (preg_match('/@endif\b/', $cleanedLine)) {
        if (empty($stack) || end($stack)['type'] !== 'if') {
            $errors[] = "Line $actualLineNum: @endif without matching @if. Stack: ".json_encode($stack);
        } else {
            array_pop($stack);
        }
    }

    // Check for @endforeach
    if (preg_match('/@endforeach\b/', $line)) {
        if (empty($stack) || end($stack)['type'] !== 'foreach') {
            $errors[] = "Line $actualLineNum: @endforeach without matching @foreach";
        } else {
            array_pop($stack);
        }
    }

    // Check for @endforelse
    if (preg_match('/@endforelse\b/', $line)) {
        if (empty($stack) || end($stack)['type'] !== 'forelse') {
            $errors[] = "Line $actualLineNum: @endforelse without matching @forelse";
        } else {
            array_pop($stack);
        }
    }

    // Check for @endphp
    if (preg_match('/@endphp\b/', $line)) {
        if (empty($stack) || end($stack)['type'] !== 'php') {
            $errors[] = "Line $actualLineNum: @endphp without matching @php";
        } else {
            array_pop($stack);
        }
    }
}

if (! empty($errors)) {
    echo "ERRORS FOUND:\n";
    foreach ($errors as $error) {
        echo "$error\n";
    }
}

if (! empty($stack)) {
    echo "\nUNCLOSED DIRECTIVES:\n";
    foreach ($stack as $item) {
        echo "{$item['type']} at line {$item['line']}\n";
    }
} elseif (empty($errors)) {
    echo "SUCCESS: All directives properly balanced!\n";
}
