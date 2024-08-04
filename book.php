<!-- Booking section -->
<section id="booking" style="background-color: #f8f9fa;">
    <div class="container">
      <h2 class="text-center">Book Your Cleaning Appointment</h2>
      <form id="bookingForm">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="date">Select Date</label>
            <input type="date" class="form-control" id="date" required>
          </div>
          <div class="form-group col-md-6">
            <label for="time">Select Time</label>
            <input type="time" class="form-control" id="time" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="name">Your Name</label>
            <input type="text" class="form-control" id="name" required>
          </div>
          <div class="form-group col-md-6">
            <label for="email">Your Email</label>
            <input type="email" class="form-control" id="email" required>
          </div>
        </div>
        <div class="form-group">
          <label for="service">Select Service</label>
          <select class="form-control" id="service" required>
            <option value="Regular Cleaning">Regular Cleaning</option>
            <option value="Deep Cleaning">Deep Cleaning</option>
            <option value="Move-In/Move-Out Cleaning">Move-In/Move-Out Cleaning</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Book Now</button>
      </form>
      <div id="bookingConfirmation" class="alert alert-success mt-3" style="display:none;"></div>
    </div>
  </section>

  
