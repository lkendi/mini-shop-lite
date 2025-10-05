/**
 * Admin dashboard charts using Chart.js.
 * Displays products by category and sales by category.
 */

document.addEventListener('DOMContentLoaded', function () {
    const productsByCategoryCtx = document.getElementById('productsByCategoryChart').getContext('2d');
    const productsByCategoryChart = new Chart(productsByCategoryCtx, {
        type: 'pie',
        data: {
            labels: productsByCategoryLabels,
            datasets: [{
                label: 'Number of Products',
                data: productsByCategoryData,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.6)',
                    'rgba(139, 92, 246, 0.6)',
                    'rgba(16, 185, 129, 0.6)',
                    'rgba(245, 158, 11, 0.6)',
                    'rgba(239, 68, 68, 0.6)',
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(139, 92, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: 'rgb(156, 163, 175)'
                    }
                }
            }
        }
    });



    const salesByCategoryCtx = document.getElementById('salesByCategoryChart').getContext('2d');
    const salesByCategoryChart = new Chart(salesByCategoryCtx, {
        type: 'bar',
        data: {
            labels: salesByCategoryLabels,
            datasets: [{
                label: 'Total Sales',
                data: salesByCategoryData,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.6)',
                    'rgba(139, 92, 246, 0.6)',
                    'rgba(16, 185, 129, 0.6)',
                    'rgba(245, 158, 11, 0.6)',
                    'rgba(239, 68, 68, 0.6)',
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(139, 92, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgb(156, 163, 175)'
                    }
                },
                x: {
                    ticks: {
                        color: 'rgb(156, 163, 175)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgb(156, 163, 175)'
                    }
                }
            }
        }
    });
});
