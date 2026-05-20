import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

export function initAvailabilityPainter() {
    const calendarEl = document.getElementById('availability-calendar');
    if (!calendarEl) return;

    // 1. Calculate the Sunday of the CURRENT week strictly using Local Time
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth();
    const currentDate = now.getDate();
    const currentDay = now.getDay(); // 0 is Sunday
    
    // This creates a fresh "Sunday 00:00:00" object for the current week
    const sundayAnchor = new Date(currentYear, currentMonth, currentDate - currentDay);
    
    const initialSlots = window.initialAvailabilities || [];
    
    const events = initialSlots.map(slot => {
        // Create a specific date for each slot based on the day_of_week
        const slotDate = new Date(sundayAnchor);
        slotDate.setDate(sundayAnchor.getDate() + parseInt(slot.day_of_week));
        
        // Format to YYYY-MM-DD
        const y = slotDate.getFullYear();
        const m = (slotDate.getMonth() + 1).toString().padStart(2, '0');
        const d = slotDate.getDate().toString().padStart(2, '0');
        const dateStr = `${y}-${m}-${d}`;
        
        return {
            id: '_' + Math.random().toString(36).substr(2, 9),
            start: `${dateStr}T${slot.start_time}`,
            end: `${dateStr}T${slot.end_time}`,
            backgroundColor: '#8B5CF6',
            borderColor: '#7C3AED',
            display: 'block'
        };
    });

    const calendar = new Calendar(calendarEl, {
        plugins: [timeGridPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        headerToolbar: false,
        dayHeaderFormat: { weekday: 'short', month: 'numeric', day: 'numeric', omitCommas: true },
        allDaySlot: false,
        slotMinTime: '06:00:00',
        slotMaxTime: '22:00:00',
        height: 'auto',
        selectable: true,
        editable: true,
        selectMirror: true,
        unselectAuto: false,
        selectOverlap: false,
        eventOverlap: false,
        events: events,
        
        select: function(selectionInfo) {
            calendar.addEvent({
                id: '_' + Math.random().toString(36).substr(2, 9),
                start: selectionInfo.start,
                end: selectionInfo.end,
                backgroundColor: '#8B5CF6',
                borderColor: '#7C3AED'
            });
            calendar.unselect();
            updateHiddenInputs();
        },
        
        eventChange: function() {
            updateHiddenInputs();
        },
        
        eventClick: function(info) {
            if (confirm('Remove this clinical block?')) {
                info.event.remove();
                updateHiddenInputs();
            }
        }
    });

    calendar.render();

    function updateHiddenInputs() {
        const container = document.getElementById('slots-data-container');
        container.innerHTML = ''; 
        
        const allEvents = calendar.getEvents();
        allEvents.forEach((event, index) => {
            // event.start.getDay() returns 0 for Sunday, 1 for Monday, etc.
            const dayOfWeek = event.start.getDay();
            
            const hours = event.start.getHours().toString().padStart(2, '0');
            const minutes = event.start.getMinutes().toString().padStart(2, '0');
            const endHours = event.end.getHours().toString().padStart(2, '0');
            const endMinutes = event.end.getMinutes().toString().padStart(2, '0');
            
            const startTime = `${hours}:${minutes}`;
            const endTime = `${endHours}:${endMinutes}`;
            
            container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="days[${dayOfWeek}][is_available]" value="1">
                <input type="hidden" name="days[${dayOfWeek}][slots][${index}][start]" value="${startTime}">
                <input type="hidden" name="days[${dayOfWeek}][slots][${index}][end]" value="${endTime}">
            `);
        });
    }

    updateHiddenInputs();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAvailabilityPainter);
} else {
    initAvailabilityPainter();
}
