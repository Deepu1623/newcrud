    <main class="content">

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
            <h2 class="mb-4">Active Students</h2>

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
                <table id="studentTable" class="table table-striped table-bordered dt-responsive nowrap table-hover" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Sr No</th>
                            <th>Admission ID</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Plan</th>
                            <th>Fees</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

      

    </main>