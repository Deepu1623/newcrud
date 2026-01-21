<style>
  

  main.content {
    display: flex;
    justify-content: center;
  }

  .profile-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 700px;
    padding: 2rem;
    color: #333;
  }

  .profile-card .card-header {
    background: #6a11cb;
    background: linear-gradient(45deg, #6a11cb, #2575fc);
    border-radius: 12px 12px 0 0;
    color: white;
    font-weight: 700;
    font-size: 1.4rem;
    text-align: center;
    padding: 1rem 0;
    margin: -2rem -2rem 2rem -2rem;
  }

  .table th {
    width: 35%;
    font-weight: 600;
    color: #555;
  }

  .table td {
    font-size: 1rem;
  }

  .badge {
    font-size: 0.9rem;
    padding: 0.4em 0.7em;
  }

  /* Hover effect on table rows */
  .table-hover tbody tr:hover {
    background-color: #f0f8ff;
  }
</style>


<main class="content">
  <div class="profile-card">

    <?php if (!empty($students)) : ?>
      <div class="card-header">
        Admission ID: <?= htmlspecialchars($students['admission_id']) ?>
      </div>
      <table class="table table-striped table-hover mb-0">
        <tbody>
          <tr>
            <th scope="row">Full Name</th>
            <td><?= htmlspecialchars($students['name']) ?></td>
          </tr>
          <tr>
            <th scope="row">Email</th>
            <td><?= htmlspecialchars($students['email'] ?? '-') ?></td>
          </tr>
          <tr>
            <th scope="row">Phone Number</th>
            <td><?= htmlspecialchars($students['number'] ?? '-') ?></td>
          </tr>
          <tr>
            <th scope="row">Plan</th>
            <td><?= htmlspecialchars($students['plan'] ?? '-') ?></td>
          </tr>
          <tr>
            <th scope="row">Address</th>
            <td><?= htmlspecialchars($students['address'] ?? '-') ?></td>
          </tr>
          <tr>
            <th scope="row">Session</th>
            <td><?= htmlspecialchars($students['session'] ?? '-') ?></td>
          </tr>
          <tr>
            <th scope="row">Fees</th>
            <td><?= htmlspecialchars($students['fees'] ?? '-') ?></td>
          </tr>
          <tr>
            <th scope="row">Admission Date</th>
            <td>
              <?php
              if (!empty($students['created_at'])) {
                echo date('d M Y, h:i A', strtotime($students['created_at']));
              } else {
                echo '-';
              }
              ?>
            </td>
          </tr>
          <tr>
            <th scope="row">Status</th>
            <td>
              <?php if ($students['status'] == 1): ?>
                <span class="badge bg-success">Active</span>
              <?php else: ?>
                <span class="badge bg-secondary">Inactive</span>
              <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-warning text-center">Student data not found.</div>
    <?php endif; ?>
  </div>
</main>
