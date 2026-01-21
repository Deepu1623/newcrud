$(document).ready(function() {
    $.ajax({
        url: base_url + "index.php/User/get_students", // API URL
        type: "GET",
        dataType: "json",
        success: function(students) {
            console.log("Students Data:", students);

            let activeCount = 0,
                inactiveCount = 0;
            let maleCount = 0,
                femaleCount = 0;

            students.forEach(student => {
                if (student.status == 1) activeCount++;
                else inactiveCount++;

                const gender = (student.gender || "").toLowerCase();
                if (gender === "male") maleCount++;
                else if (gender === "female") femaleCount++;
            });

            // Charts create karna
            createCharts(activeCount, inactiveCount, maleCount, femaleCount);
        },
        error: function(err) {
            console.error("Error fetching students:", err);
        }
    });

    function createCharts(activeCount, inactiveCount, maleCount, femaleCount) {
        // Student Status Chart
        const statusCtx = document.getElementById("statusChart").getContext("2d");
        new Chart(statusCtx, {
            type: "doughnut",
            data: {
                labels: ["Active", "Inactive"],
                datasets: [{
                    data: [activeCount, inactiveCount],
                    backgroundColor: ["#28a745", "#dc3545"],
                    borderColor: ["#fff", "#fff"],
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { position: "bottom" },
                    datalabels: {
                        color: "#fff",
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            return value + " (" + ((value / total) * 100).toFixed(1) + "%)";
                        },
                        font: { weight: "bold", size: 13 }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Gender Distribution Chart
        const genderCtx = document.getElementById("genderChart").getContext("2d");
        new Chart(genderCtx, {
            type: "doughnut",
            data: {
                labels: ["Male", "Female"],
                datasets: [{
                    data: [maleCount, femaleCount],
                    backgroundColor: ["#007bff", "#e83e8c"],
                    borderColor: ["#fff", "#fff"],
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { position: "bottom" },
                    datalabels: {
                        color: "#fff",
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            return value + " (" + ((value / total) * 100).toFixed(1) + "%)";
                        },
                        font: { weight: "bold", size: 13 }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
});
