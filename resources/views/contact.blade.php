@extends("template.main")
@section('title', 'Contact Us')
@section('body')
<div class="row d-flex justify-content-center m-5">

  <!-- Contact Form Block -->
  <div class="col-xl-6">
    <h2 class="pb-4">Leave a message</h2>
    <form method="POST" action="{{ url('/contact') }}">
        @csrf
        <div class="row g-4">
        <div class="col-12 mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" placeholder="John">
        </div>
        </div>
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Phone</label>
        <input type="tel" class="form-control" name="phone" placeholder="+1234567890">
        </div>
        <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Message</label>
        <textarea class="form-control" name="message" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>

        <!-- Button to view contact list -->
        <a href="{{ url('/contact/list') }}" class="btn btn-primary">View Contact List</a>
    </form>

    <!-- Success message box -->
    <div id="success-message" class="alert alert-success mt-3" style="display: none;">
        Your message has been sent successfully.
    </div>
  </div>
</div>

<!-- JavaScript to show success message after form submission -->
<script>
    // Display success message after form submission
    @if(session('success'))
    document.getElementById('success-message').style.display = 'block';
    @endif
</script>
@endsection