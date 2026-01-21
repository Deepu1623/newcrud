<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wellness Gym</title>

  <!-- Core CSS -->
  <!-- Core CSS -->
  <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet">

  <!-- Plugins CSS -->
  <link href="<?php echo base_url('assets/css/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/responsive.bootstrap5.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/sweetalert2.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/fonts/font-awesome.min.css'); ?>" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>

<body>
  <?php $user_id = $this->session->userdata('userID'); ?>
  <header class="header">
    <div class="logo">Wellness Gym</div>
    <div class="menu-icon" onclick="toggleSidebar()">☰</div>
    <nav class="nav">
      <a href="#contact"><?php echo $user_id; ?></a>
    </nav>
  </header>