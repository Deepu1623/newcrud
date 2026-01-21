    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;400;700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet">



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <main class="content">
  <div class="container py-4">

    <!-- Setup Months Card -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Setup Months</h4>
      </div>
      <div class="card-body">
        <form method="post" action="" id="setup_months">
          <div class="mb-3">
            <input type="text" class="form-control" name="months_Setup" id="months_Setup" placeholder="Enter Months..." required>
          </div>
          <button type="submit" name="submit_single" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

    <!-- Adding Fees Month Wise Card -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-success text-white">
        <h4 class="mb-0">Adding Fees Month Wise</h4>
      </div>
      <div class="card-body">
        <form method="post" action="" id="adding_fees">
          <div class="row g-3">
            <div class="col-md-6">
              <select class="form-select" name="months" id="months" required>
                <option value="">Select a Month</option>
                <?php if (!empty($months)) {
                  foreach ($months as $mon) { ?>
                    <option value="<?php echo $mon['month'] ?>"><?php echo $mon['month'] ?></option>
                <?php }
                } ?>
              </select>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="fees" id="fees" placeholder="Enter Fees Amount..." required>
            </div>
          </div>
          <div class="mt-3">
            <button type="submit" name="submit_dropdown" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Listing Card -->
    <div class="card shadow-sm">
      <div class="card-header bg-info text-white">
        <h4 class="mb-0">Listings</h4>
      </div>
      <div class="card-body">

        <!-- Months Table -->
        <h5 class="mb-3">Months</h5>
        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>Month</th>
              <th style="width: 120px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($months)) {
              foreach ($months as $mon) { ?>
                <tr>
                  <td><?php echo $mon['month']; ?></td>
                  <td>
                    <button id="delete_btn" class="btn btn-danger btn-sm" onclick="deleteMonth(<?php echo $mon['srno']; ?>)">Delete</button>
                  </td>
                </tr>
            <?php }
            } ?>
          </tbody>
        </table>

        <!-- Month Wise Fees Table -->
        <h5 class="mt-5 mb-3">Month Wise Fees</h5>
        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>Month</th>
              <th>Fee</th>
              <th style="width: 120px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($month_fees)) {
              foreach ($month_fees as $fee) { ?>
                <tr>
                  <td><?php echo $fee['month']; ?></td>
                  <td><?php echo $fee['fees']; ?></td>
                  <td>
                    <button id="delete_btn" class="btn btn-danger btn-sm" onclick="deleteFee(<?php echo $fee['srno']; ?>)">Delete</button>
                  </td>
                </tr>
            <?php }
            } ?>
          </tbody>
        </table>

      </div>
    </div>

  </div>
</main>



    <script>
        $(document).ready(function() {
            $('#setup_months').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const months_Setup = $('#months_Setup').val();
                const base_url = "<?= base_url(); ?>";


                // Show SweetAlert confirmation BEFORE submitting
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to submit this data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked "Yes"
                        $.ajax({
                            url: base_url + 'index.php/User/month_setup',
                            type: 'POST',
                            data: {
                                months_setup: months_Setup,
                            },
                            success: function(response) {
                                if (response.trim() == 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Successfully Submitted',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Redirect after success
                                        window.location.href = base_url + 'index.php/User/fee_setup';
                                    });
                                } else if (response.trim() == 'exists') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Month  already exists',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'failed: ' + xhr.responseText,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                    // If user clicks "Cancel", nothing happens.
                });
            });
        });


        $(document).ready(function() {
            $('#adding_fees').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const months = $('#months').val();
                const fees = $('#fees').val();
               const base_url = "<?= base_url(); ?>";

                // Show SweetAlert confirmation BEFORE submitting
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to submit this data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked "Yes"
                        $.ajax({
                            url: base_url + 'index.php/User/fees_adding',
                            type: 'POST',
                            data: {
                                months: months,
                                fees: fees,
                            },
                            success: function(response) {
                                if (response.trim() == 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Successfully Submitted',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Redirect after success
                                        window.location.href = base_url + 'index.php/User/fee_setup';
                                    });
                                } else if (response.trim() == 'exists') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Month  already exists',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'failed: ' + xhr.responseText,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                    // If user clicks "Cancel", nothing happens.
                });
            });
        });


        function deleteMonth(srno) {
           const base_url = "<?= base_url(); ?>";
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User clicked "Yes"
                    $.ajax({
                        url: base_url + 'index.php/User/deleteMonthNames',
                        type: 'POST',
                        data: {
                            srno: srno,
                        },
                        success: function(response) {
                            if (response.trim() == 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Successfully deleted',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect after success
                                    window.location.href = base_url + 'index.php/User/fee_setup';
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'failed: ' + xhr.responseText,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
                // If user clicks "Cancel", nothing happens.
            });
        }



        function deleteFee(srno) {
            const base_url = "<?= base_url(); ?>";
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User clicked "Yes"
                    $.ajax({
                        url: base_url + 'index.php/User/DeleteFeeData',
                        type: 'POST',
                        data: {
                            srno: srno,
                        },
                        success: function(response) {
                            if (response.trim() == 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Successfully deleted',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect after success
                                    window.location.href = base_url + 'index.php/User/fee_setup';
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'failed: ' + xhr.responseText,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
                // If user clicks "Cancel", nothing happens.
            });
        }
    </script>