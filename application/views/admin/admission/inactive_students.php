    <main class="content">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

        <style>
            .table-responsive {
                overflow-x: auto;
            }

            #studentTable tbody td {
                text-align: center;
                /* Horizontal center */
                vertical-align: middle;
                /* Vertical center */
            }
        </style>
        <div class="container py-4">
            <h2 class="mb-4">Inactive Students</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="filter-name">Filter by Name</label>
                    <select id="filter-name" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['name'] ?>"><?= $student['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="filter-admission-id">Filter by Admission ID</label>
                    <select id="filter-admission-id" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['admission_id'] ?>"><?= $student['admission_id'] . " (" . $student['name'] . ")"; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table id="inactive_studentTable" class="table table-striped table-bordered dt-responsive nowrap table-hover" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Sr No</th>
                            <th>Admission ID</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Plan</th>
                            <th>Fees</th>
                            <th>Inactive by</th>
                            <th>Inactive at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

        <script>
            $(document).ready(function() {
                // Define the table variable in global scope
                var table = $('#inactive_studentTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: "<?= base_url('index.php/User/get_inactive_student_ajax') ?>",
                        type: "POST",
                        data: function(d) {
                            d.name = $('#filter-name').val();
                            d.admission_id = $('#filter-admission-id').val();
                        }
                    },
                    columns: [{
                            data: 'srno'
                        },
                        {
                            data: 'admission_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'number'
                        },
                        {
                            data: 'plan'    
                        },
                        {
                            data: 'fees'
                        },
                        {
                            data: 'inactive_by'
                        },
                        {
                            data: 'inactive_at'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Make sure this event is inside the same block where 'table' is defined
                $('#filter-name, #filter-admission-id').on('change', function() {
                    table.ajax.reload();
                });
            });
        </script>

    </main>