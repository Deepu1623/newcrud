<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Header</title>
  <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;400;700&display=swap" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/plugins/jquery-3.7.0.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.min.css'); ?>">



</head>

<body>


  <aside class="sidebar" id="sidebar">
    <ul>

      <li><a href="<?php echo base_url('index.php/User/dashboard') ?>">Dashboard</a></li>


      <li>
        <a href="#" class="dropdown-toggle">Admissions</a>
        <ul class="submenu">
          <li><a href="<?php echo base_url('index.php/User/student_admission'); ?>">New Admission</a></li>
          <li><a href="<?php echo base_url('index.php/User/student_report'); ?>">Active Students</a></li>
          <li><a href="<?php echo base_url('index.php/User/inactive_students'); ?>">Inactive Students</a></li>
        </ul>
      </li>

      <li>
        <a href="#" class="dropdown-toggle">Fees</a>
        <ul class="submenu">
          <li><a href="<?php echo base_url('index.php/User/fee_setup'); ?>">Fee Setup</a></li>
          <li><a href="#">Fee Report</a></li>
        </ul>
      </li>

      <li><a href="<?php echo base_url('index.php/User/logout'); ?>">Logout</a></li>
    </ul>
  </aside>





  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }
  </script>

  <script>
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();

        const parent = this.parentElement;

        // Close all other submenus
        document.querySelectorAll('.sidebar li').forEach(li => {
          if (li !== parent) {
            li.classList.remove('open');
            const sub = li.querySelector('.submenu');
            if (sub) sub.style.display = 'none';
          }
        });

        // Toggle clicked submenu
        parent.classList.toggle('open');
        const submenu = parent.querySelector('.submenu');
        if (submenu) {
          submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        }
      });
    });
  </script>

  <script>
    const base_url = "<?= base_url(); ?>";
  </script>
  <script src="<?= base_url('assets/js/admin.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




</body>

</html>