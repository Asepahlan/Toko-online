import './bootstrap';

// Tambahkan kode ini untuk debug
document.addEventListener('DOMContentLoaded', () => {
    // Debug auto-refresh
    let refreshCount = 0;
    const observer = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
            if (entry.name.includes('default-category.png')) {
                console.log(`Image loaded ${++refreshCount} times`, {
                    timestamp: new Date().toISOString(),
                    duration: entry.duration,
                    initiatorType: entry.initiatorType
                });
            }
        }
    });

    observer.observe({ entryTypes: ['resource'] });
});