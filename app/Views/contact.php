<?php
/**
 *
 */
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Contact form page</h1>
            <form method="post" action="/contact">

                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullName" id="fullName" placeholder="John Snow">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="John_Snow">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="john.snow@example.com">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control" id="content" rows="3" placeholder="I am a King of the North!"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
