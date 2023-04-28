<footer class="landing-footer">
    <div class="container">
        <form action="#" class="contact">
            <h4 class="">Contact Us</h4>
            <div class="fields">
                <div class="floating_form">
                    <input type="text" id="name" class="form-control" placeholder="a">
                    <label for="name" class="floating_label">Your Name</label>
                </div>
                <div class="floating_form">
                    <input type="email" id="email" class="form-control" placeholder="a">
                    <label for="email" class="floating_label">Your Email</label>
                </div>
                <div class="floating_form">
                    <textarea name="message" id="" cols="15" rows="5" placeholder="a" class="form-control"></textarea>
                    <label for="message" class="floating_label">Your Message</label>
                </div>
            </div>
            <button type="button" class="my-btn-primary">
                Send Message
            </button>
        </form>
    </div>
    <div class="footer-bottom">
        <h5 class="m-0"> &copy; <?= (new DateTime())->format("Y") ?> WebSaint </h5>
        <div class="right">
            <h5 class="m-0">Follow Us</h5>
            <ul class="icons">
                <li class="icon">
                    <a href="#" class="link-primary">
                        <i class="fab fa-facebook" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="icon">
                    <a href="#" class="link-primary">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="icon">
                    <a href="#" class="link-primary">
                        <i class="fab fa-linkedin" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>