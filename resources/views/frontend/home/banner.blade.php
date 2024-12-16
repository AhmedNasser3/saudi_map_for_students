<div class="banner">
    <main>
        <div class="slider">
            <div id="notification" class="notification" style="display: none;">
                <p id="notification-message"></p>
                <div class="progress-bar"></div>
            </div>
            <div class="main_container">
                <div class="main_data">
                    <div class="main_content">
                        <div class="main_title">
                            <div class="main_img">
                                                  </div>
                        </div>
                        <div class="main_banner">
                            <div class="main_banner_img">

                                <img src="{{ asset('images/WhatsApp Image 2024-12-14 at 6.50.52 PM.jpeg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</div>
<style>
/* main */
.container_frontend {
    width: 100%;
    padding: 0 15%;
    background-color: #ffffff;
}

.main {
    width: 100%;
}

.main_container {
    padding: 8% 0 0 0;
    direction: rtl;
}

.main_title {
    display: flex;
    align-items: center;
}

.main_img h1 {
    color: #131313;
}

.main_user_name span {
    color: #5d818a;
    border-bottom: 2px solid #1ffffb;
}

.main_banner {
    padding: 2% 0 0 0;
}

.main_banner_img {
    width: 100%;
    height: 400px;
    overflow: hidden;
    position: relative;
}

.main_banner_img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.main_profile_circle {
    width: 60px;
    height: 60px;
    background-color: black;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
    margin-left: 20px;
}

.main_banner {
    direction: ltr;
}

.main_box_bg {
    position: absolute;
    background-color: white;
    width: 500px;
    height: 300px;
    box-shadow: 1px 5px 10px #1313131f;
    display: grid;
    transform: translateY(50px) translateX(50px);
}

.main_box_title {
    direction: rtl;
    padding: 20px;
}

.main_box_title {
    font-size: 2rem;
    color: #131313;
}

.main_box_btn {
    position: absolute;
    bottom: 20px;
    left: 20%;
    transform: translateX(-50%);
    direction: ltr;
}

.main_box_btn button {
    background-color: #131313;
    padding: 15px 30px;
    border: none;
}

.main_box_btn button:hover {
    background-color: #4c4c4c;
    padding: 15px 30px;
    border: none;
}

.main_box_btn button a {
    color: white;
    font-size: 1.1rem;
}

.main_box_title p {
    font-size: 1.6rem;
    color: #767676;
}

/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    .main_container {
        padding: 5% 0 0 0;
    }

    .main_banner_img {
        height: 300px; /* Make banner smaller on smaller screens */
    }

    .main_box_bg {
        width: 90%;
        height: auto; /* Allow the box to adjust its size based on content */
        transform: translateY(10px) translateX(5%);
    }

    .main_box_title {
        font-size: 1.6rem;
    }

    .main_box_btn button {
        padding: 10px 20px;
    }

    .main_box_btn button a {
        font-size: 1rem;
    }

    /* Adjust image size for mobile */
    .main_banner_img img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
}

@media (max-width: 480px) {
    .main_container {
        padding: 3% 0 0 0;
    }

    .main_banner_img {
        height: 250px; /* Further adjust the banner height on smaller screens */
    }

    .main_box_bg {
        width: 100%;
        height: auto;
        transform: translateY(10px) translateX(0);
    }

    .main_box_title {
        font-size: 1.4rem;
    }

    .main_box_btn button {
        padding: 8px 15px;
    }

    .main_box_btn button a {
        font-size: 0.9rem;
    }

    /* Adjust image size further for very small screens */
    .main_banner_img img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
}
</style>
