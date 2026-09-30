<section class="cn-faq-section" id="faq">

    <div class="container">

        <div class="cn-faq-heading">

            <div class="cn-faq-kicker">
                <span></span>
                FAQ
                <b>✦</b>
            </div>

            <h2>
                Frequently Asked
                <span>Questions</span>
            </h2>

            <p>
                Everything you need to know about CleanNora cleaning services.
            </p>

        </div>


        <div class="cn-faq-list">

            <div class="cn-faq-item active">

                <button class="cn-faq-question" type="button">
                    <span>What cleaning services does CleanNora provide?</span>
                    <i class="bi bi-plus"></i>
                </button>

                <div class="cn-faq-answer">
                    <p>
                        CleanNora provides professional home and commercial cleaning
                        services including home cleaning, deep cleaning, kitchen
                        cleaning, bathroom cleaning, sofa cleaning, carpet cleaning,
                        window cleaning, office cleaning and more.
                    </p>
                </div>

            </div>


            <div class="cn-faq-item">

                <button class="cn-faq-question" type="button">
                    <span>How can I book a cleaning service?</span>
                    <i class="bi bi-plus"></i>
                </button>

                <div class="cn-faq-answer">
                    <p>
                        You can book a service directly through the CleanNora
                        website by selecting your preferred service, choosing a
                        suitable date and time, and completing your booking details.
                    </p>
                </div>

            </div>


            <div class="cn-faq-item">

                <button class="cn-faq-question" type="button">
                    <span>Which areas does CleanNora currently serve?</span>
                    <i class="bi bi-plus"></i>
                </button>

                <div class="cn-faq-answer">
                    <p>
                        CleanNora currently provides cleaning services in Noida
                        and Greater Noida.
                    </p>
                </div>

            </div>


            <div class="cn-faq-item">

                <button class="cn-faq-question" type="button">
                    <span>Can I schedule a cleaning for a specific date and time?</span>
                    <i class="bi bi-plus"></i>
                </button>

                <div class="cn-faq-answer">
                    <p>
                        Yes. You can select your preferred date and available
                        time slot while making your booking.
                    </p>
                </div>

            </div>


            <div class="cn-faq-item">

                <button class="cn-faq-question" type="button">
                    <span>Can I track my booking after placing an order?</span>
                    <i class="bi bi-plus"></i>
                </button>

                <div class="cn-faq-answer">
                    <p>
                        Yes. CleanNora provides booking management and tracking
                        options so you can keep track of your service.
                    </p>
                </div>

            </div>


            <div class="cn-faq-item">

                <button class="cn-faq-question" type="button">
                    <span>What if I need help with my booking?</span>
                    <i class="bi bi-plus"></i>
                </button>

                <div class="cn-faq-answer">
                    <p>
                        Our support team is available to help with booking
                        questions, service details and other assistance.
                    </p>
                </div>

            </div>

        </div>

    </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const faqItems = document.querySelectorAll('.cn-faq-item');

    faqItems.forEach(function (item) {

        const question = item.querySelector('.cn-faq-question');

        if (!question) return;

        question.addEventListener('click', function () {

            const isActive = item.classList.contains('active');

            // Close all FAQs
            faqItems.forEach(function (faq) {
                faq.classList.remove('active');

                const icon = faq.querySelector('.cn-faq-question i');

                if (icon) {
                    icon.classList.remove('bi-dash');
                    icon.classList.add('bi-plus');
                }
            });

            // Open clicked FAQ
            if (!isActive) {
                item.classList.add('active');

                const icon = item.querySelector('.cn-faq-question i');

                if (icon) {
                    icon.classList.remove('bi-plus');
                    icon.classList.add('bi-dash');
                }
            }

        });

    });

});
</script>