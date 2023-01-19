<footer class="mt-md-5 footer-section py-4 mt-4">
    <div class="container">
        <div class="row footer-top mt-3">
            <div class="col-md-6 text-start">
                <ul class="footer-ul footer-left-links">
                    <li><a  href="{{ route('privacyPolicy') }}">Privacy</a></li>
                    <li><a  href="{{ route('terms') }}">Terms</a></li>
                    <li><a  href="{{ route('guideline') }}">Guidelines</a></li>
                </ul>
            </div>
            <div class="col-md-6 text-end">
                <ul class="footer-ul footer-right-links">
                    <li><a  href="{{ route('faq') }}">FAQ</a></li>
                    <li><a  href="{{ url('/contact-us') }}">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom mt-3 d-flex justify-content-between">
            <div class="footer-logo">
                <img src="{{ asset('assets/img/logo-colored.png') }}" class="img-fluid"> 
                <p> © {{ date('Y') }}, Fansfluence LLC</p>
            </div>
            <div class="footer-bottom-right">
                <ul class="footer-ul footer-social-media">
                    <li>
                        <a href="https://twitter.com/login" target="_blank" class="footer-twitter">
                            <img src="{{ asset('assets/img/twitter-icon.png') }}">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/" target="_blank" class="footer-youtube">
                            <img src="{{ asset('assets/img/youtube-icon.png') }}">
                        </a>
                    </li>
                    <li><a  href="javascript:void(0);"><i class="fa fa-globe"></i> English</a></li>
                    <li><a  href="javascript:void(0);">$ USD</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
