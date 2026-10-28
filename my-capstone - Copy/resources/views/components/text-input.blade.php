@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-300 focus:border-clinic-blue-medium focus:ring-clinic-blue-medium rounded-md shadow-sm bg-white dark:bg-white text-gray-900 dark:text-gray-900']) }}>
