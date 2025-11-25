document.addEventListener("DOMContentLoaded", () => {

    const labels = JSON.parse(document.getElementById("labels-data").value);
    const data = JSON.parse(document.getElementById("solde-data").value);

    const ctx = document.getElementById("chartSolde").getContext("2d");

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Solde total (DH)',
                data: data,
                borderWidth: 3,
                backgroundColor: 'rgba(60, 141, 188, 0.3)',
                borderColor: '#3c8dbc',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
        }
    });
});
