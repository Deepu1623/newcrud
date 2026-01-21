
    <main class="content my-3" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="card shadow-lg p-4 rounded-4" style="max-width: 600px; margin: auto;">
                <h2 class="mb-4 text-center text-primary">Add New Gym Student</h2>
                <form action="" method="POST" id="student_admission" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                    <!-- Full Name -->
                    <div class="col-md-12">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="name" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control rounded-3 shadow-sm" id="email" name="email" required>
                    </div>

                    <!-- Address -->
                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control rounded-3 shadow-sm" id="address" name="address" rows="3" required></textarea>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <label for="number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control rounded-3 shadow-sm" id="number" name="number" required minlength="10" maxlength="10">
                    </div>



                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select rounded-3 shadow-sm" id="gender" name="gender" required>
                            <option value="">Select gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>                           
                        </select>
                    </div>


                    <!-- Month Plan -->
                    <div class="col-md-6">
                        <label for="plan" class="form-label">Month Plan</label>
                        <select class="form-select rounded-3 shadow-sm" id="plan" name="plan" required onchange="getting_fees();">
                            <option value="">Select Plan --</option>
                            <?php if (!empty($months)) {
                                foreach ($months as $mon) { ?>

                                    <option value="<?php echo $mon['month']   ?>"><?php echo $mon['month']   ?></option>

                            <?php      }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="number" class="form-label">Fees</label>
                        <input type="number" class="form-control rounded-3 shadow-sm" id="fees" name="fees" required readonly>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 shadow-sm mt-3">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

