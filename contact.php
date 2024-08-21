<!-- Contact section -->
<?php include './includes/header.php'; ?>

<section id="contact">
    <div class="container">
      <h2 class="text-center">Contact Us</h2>
      <form action="contact_form.php">
        <div class="form-group">
          <label for="contactName">Name</label>
          <input type="text" class="form-control" id="contactName" required>
        </div>
        <div class="form-group">
          <label for="contactEmail">Email</label>
          <input type="email" class="form-control" id="contactEmail" required>
        </div>
        <div class="form-group">
          <label for="contactMessage">Message</label>
          <textarea class="form-control" id="contactMessage" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Send</button>
      </form>
    </div>
  </section>
  <?php include './includes/footer.php'; ?>
