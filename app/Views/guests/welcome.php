<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> - Welcome <?= esc($guest['full_name']) ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://kit.fontawesome.com/cc5d7cb79f.js" crossorigin="anonymous"></script>

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="/assets/media/fonts/Moeda.css">
    <style>
        @font-face {
            font-family: 'Moeda';
            src: url('/assets/media/fonts/Moeda.woff') format('woff'),
                url('/assets/media/fonts/Moeda.ttf') format('truetype'),
                url('/assets/media/fonts/Moeda.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'OpenSans';
            src: url('/assets/media/fonts/OpenSansRegular.woff') format('woff'),
                url('/assets/media/fonts/OpenSansRegular.ttf') format('truetype'),
                url('/assets/media/fonts/OpenSansRegular.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        body,
        p,
        span,
        div,
        li,
        ul,
        ol,
        a,
        input,
        textarea,
        button {
            font-family: 'OpenSans', Arial, sans-serif;
            font-size: 1em;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Moeda', Arial, sans-serif;
            font-size: 2em;
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .container.my-5 {
                margin-top: 1rem !important;
                margin-bottom: 1rem !important;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .btn {
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Welcome Page Specific Styles */
        .welcome-header {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('/assets/media/hotel/header.webp') center center/cover no-repeat;
        }

        .welcome-logo {
            height: 120px;
        }

        .welcome-content {
            max-width: 600px;
            width: 100%;
        }

        .info-table-container {
            max-width: 600px;
            margin: auto;
        }

        .info-table {
            color: #333;
            font-size: 1.0rem;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #ddd;
        }

        .info-table td {
            padding: 12px 8px;
        }

        .info-table td:first-child {
            font-weight: 500;
            width: 50%;
            border-right: 1px solid #ddd;
        }

        .guest-action-margin {
            margin-top: 8px;
        }

        .modal-header h4 {
            font-size: 1.3rem;
        }
    </style>
</head>

<body>
    <div class="container my-5 px-2 px-sm-3">
        <div class="mt-4">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="welcome-header">
                    <img src="/assets/media/hotel/logo.png" alt="Company Logo" class="welcome-logo">
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="mb-4">
                <div class="d-flex justify-content-center">
                    <div class="welcome-content">
                        <p>Dear <?= esc($guest['full_name']) ?>,</p>
                        <p>Greetings from .Here Baa Atoll, Maldives!</p>
                        <p>.Here Baa Atoll is more than a destination. It is an invitation to feel fully alive.</p>
                        <p>We are delighted that you have selected our exquisite resort for your upcoming holiday. At
                            .Here Baa Atoll two islands – Somewhere and Nowhere – invite you into a world of duality.
                            Wander from the largest private lagoon in the Maldives along the sweeping sandbank to the
                            boundless open ocean or relax in residences that are both grand in scale and crafted for
                            privacy.</p>

                        <p>At .Here we create bespoke experiences that last a lifetime and emotions that you will take
                            away forever with you.</p>
                        <p>By clicking on ‘MY .HERE PREFERENCES’ in this page below, you may help us with preparing for
                            your upcoming stay with us. It should only take a few minutes of your time.</p>


                        <br>
                        <p>As we eagerly anticipate your arrival, we are pleased to provide confirmation for your stay
                            with the following details:</p>

                    </div>
                </div>
            </div>

            <div class="mb-4">

                <div class="mb-4 info-table-container">
                    <table class="table info-table">
                        <tbody>
                            <tr>
                                <td>
                                    Travel Dates</td>
                                <td>
                                    <?php if (!empty($guest['arrival_date']) && !empty($guest['departure_date'])): ?>
                                    <?= date('d/m/y', strtotime($guest['arrival_date'])) ?> -
                                    <?= date('d/m/y', strtotime($guest['departure_date'])) ?>
                                    <?php else: ?>
                                    DD/MM/YY - DD/MM/YY
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Number of
                                    Nights</td>
                                <td>
                                    <?php 
                                    if (!empty($guest['arrival_date']) && !empty($guest['departure_date'])) {
                                        $arrival = new DateTime($guest['arrival_date']);
                                        $departure = new DateTime($guest['departure_date']);
                                        $nights = $arrival->diff($departure)->days;
                                        echo $nights . ' Nights';
                                    } else {
                                        echo 'XX Nights';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td
                                   >
                                    Number of Guests / Names</td>
                                <td>
                                    <?php
                                    $adults = !empty($guest['adults']) ? $guest['adults'] : 1;
                                    $children = !empty($guest['children']) ? $guest['children'] : 0;
                                    $total = $adults + $children;
                                    echo $total . ' Adults';
                                    ?>
                                    <br>
                                    <div class="guest-action-margin">
                                        <strong>Mr. <?= esc($guest['full_name']) ?></strong><br>
                                        <?php if (!empty($guest['accompanying_guests'])): ?>
                                        <strong><?= esc($guest['accompanying_guests']) ?></strong>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Residence Type
                                </td>
                                <td>
                                    <?php if (!empty($guest['villa_name'])): ?>
                                    <strong><?= esc($guest['villa_name']) ?></strong>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td
                                   >
                                    Meal Plan</td>
                                <td>
                                    <?php if (!empty($guest['inclusive'])): ?>
                                    <?= esc($guest['inclusive']) ?>
                                    <?php endif; ?>
                                    <br>
                                    <div class="guest-action-margin">
                                        More Information (Link to the website)
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td
                                   >
                                    Flight & Transfer Details</td>
                                <td>
                                    <?php if (!empty($guest['arrival_to_here']) || !empty($guest['departure_from_here'])): ?>
                                    Shared Seaplane Transfer
                                    <br>
                                    <div class="guest-action-margin">
                                        Arrival:
                                        <?= !empty($guest['arrival_to_here']) ? esc($guest['arrival_to_here']) : 'XXX' ?><br>
                                        Departure:
                                        <?= !empty($guest['departure_from_here']) ? esc($guest['departure_from_here']) : 'XXXX' ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Confirmation
                                    Number</td>
                                <td>
                                    <?= !empty($guest['reservation_code']) ? esc($guest['reservation_code']) : 'XXXXXX' ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#guestListModal">
                        Preferences
                    </button>
                </div>

                <!-- Modal for guest list -->
                <div class="modal fade" id="guestListModal" tabindex="-1" aria-labelledby="guestListModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="guestListModalLabel">MY .HERE PREFERENCES</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-3 text-muted">Please fill out your preferences for each guest in your
                                    reservation.</p>
                                <ul class="list-group mb-3">
                                    <?php if (!empty($allReservationGuests)): ?>
                                    <?php foreach ($allReservationGuests as $reservationGuest): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="guest-action-margin">
                                            <span class="fw-bold"><?= esc($reservationGuest['full_name']) ?></span>
                                            <small
                                                class="text-muted d-block"><?= ucfirst(esc($reservationGuest['guest_type'])) ?></small>
                                        </div>
                                        <a href="<?= base_url('preferences/' . $reservationGuest['guest_token']) ?>"
                                            class="btn btn-sm btn-dark" target="_blank">Fill Preferences</a>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <li class="list-group-item">
                                        <span>No guests found for this reservation.</span>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Preferences will open in a new tab for each guest.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="mt-5 py-4 bg-light">
                    <div class="container d-flex justify-content-center">
                        <a href="https://www.facebook.com/profile.php?id=61577687646689" target="_blank"
                            class="mx-3 text-secondary">
                           <i class="fa-brands fa-square-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/_.herebaaatoll" target="_blank" class="mx-3 text-secondary"
                           >
                            <i class="fa-brands fa-square-instagram"></i>
                        </a>
                        <a href="https://www.here-maldives.com/" target="_blank" class="mx-3 text-secondary">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
