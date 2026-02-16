document.addEventListener("DOMContentLoaded", () => {

    // Data načtená z dataset atributu v HTML
    const chartElement = document.getElementById("reservationsChart");

    if (!chartElement) return;

    const labels  = JSON.parse(chartElement.dataset.labels);
    const values  = JSON.parse(chartElement.dataset.values);

    const ctx = chartElement.getContext("2d");

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Počet rezervací',
                data: values,
                backgroundColor: '#03c4c9',
                borderColor: '#02a4a8',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
