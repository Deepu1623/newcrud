

<style>
    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card-header {
        font-weight: bold;
        font-size: 1.1rem;
        text-align: center;
        padding: 0.75rem 1rem;
        border-bottom: none;
    }

    .card-body {
        padding: 1rem;
        background-color: #f9f9f9;
    }

    .card-body canvas {
        max-width: 90%;
        height: auto !important;
        max-height: 300px !important;
        margin: 0 auto;
    }

    @media (max-width: 767.98px) {
        .card-body canvas {
            max-height: 270px !important;
        }
    }
</style>



<main class="content">
    <div class="container-sm mt-4">
        <div class="row">
            <!-- Student Status Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg bg-light">
                    <div class="card-header bg-success text-white">
                        Student Status
                    </div>
                    <div class="card-body text-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gender Distribution Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg bg-light">
                    <div class="card-header bg-info text-white">
                        Gender Distribution
                    </div>
                    <div class="card-body text-center">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

