<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$sql = "SELECT * FROM contact_messages ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<title>Dashboard - Card View</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    padding: 0;
    margin: 0;
}

/* Topbar */
.topbar {
    background: #0a1628;
    color: #fff;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.topbar h2 {
    margin: 0;
    font-size: 1.3rem;
}

.logout-btn {
    background: #ce2026;
    color: #fff;
    padding: 8px 18px;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 500;
    transition: 0.2s;
    display: inline-block;
}

.logout-btn:hover {
    background: #a01a1f;
    transform: scale(1.02);
}

/* Container */
.container {
    padding: 20px 16px 40px 16px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Stats row (optional) */
.stats {
    background: white;
    border-radius: 20px;
    padding: 12px 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.total-count {
    font-weight: 600;
    color: #0a1628;
    background: #eef2ff;
    padding: 6px 14px;
    border-radius: 40px;
    font-size: 0.85rem;
}

/* ----- CARD GRID (Mobile First) ----- */
.card-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

/* Card styling */
.message-card {
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: 0.2s ease;
    border: 1px solid #e9edf2;
}

.message-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}

/* Card header */
.card-header {
    background: #f8fafd;
    padding: 16px 20px;
    border-bottom: 1px solid #eef2f6;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.id-badge {
    background: #0a1628;
    color: white;
    font-size: 0.75rem;
    padding: 4px 12px;
    border-radius: 40px;
    font-weight: 500;
}

.date {
    color: #5c6f87;
    font-size: 0.75rem;
    background: #eef2fa;
    padding: 4px 12px;
    border-radius: 40px;
}

/* Card body */
.card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.info-row {
    display: flex;
    flex-wrap: wrap;
    border-bottom: 1px dashed #edf2f7;
    padding-bottom: 12px;
}

.info-label {
    width: 90px;
    font-weight: 700;
    color: #1e2a44;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    flex: 1;
    color: #1f2a48;
    font-weight: 500;
    word-break: break-word;
    font-size: 0.95rem;
}

.info-value a {
    color: #0a66b9;
    text-decoration: none;
}

.info-value a:hover {
    text-decoration: underline;
}

/* Message section - always at bottom */
.message-section {
    background: #f9fbfe;
    border-radius: 18px;
    padding: 16px;
    margin-top: 6px;
    border-left: 4px solid #0a1628;
}

.message-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 800;
    color: #4a5b7a;
    letter-spacing: 1px;
    margin-bottom: 10px;
    display: block;
}

.message-text {
    color: #2c3e50;
    line-height: 1.55;
    font-size: 0.92rem;
    white-space: pre-wrap;
    word-break: break-word;
}

/* Service chip */
.service-chip {
    background: #eef2ff;
    color: #0a58ca;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-block;
}

/* Phone styling */
.phone-link {
    color: #1e3a5f;
    text-decoration: none;
    font-weight: 500;
}

/* Tablet and desktop responsive */
@media (min-width: 640px) {
    .card-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .container {
        padding: 24px 24px 40px;
    }
}

@media (min-width: 1024px) {
    .card-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .container {
        padding: 30px 32px 50px;
    }
    .topbar h2 {
        font-size: 1.6rem;
    }
}

/* Empty state */
.empty-state {
    background: white;
    border-radius: 32px;
    padding: 60px 20px;
    text-align: center;
    color: #6c7a91;
    font-size: 1rem;
}

/* small touch */
@media (max-width: 480px) {
    .card-body {
        padding: 16px;
    }
    .info-label {
        width: 75px;
        font-size: 0.7rem;
    }
    .info-value {
        font-size: 0.85rem;
    }
    .message-text {
        font-size: 0.85rem;
    }
}

</style>
</head>
<body>

<div class="topbar">
    <h2>📋 Contact Messages</h2>
    <a class="logout-btn" href="logout.php">Logout</a>
</div>

<div class="container">

    <?php 
    $totalRows = mysqli_num_rows($result);
    if ($totalRows > 0) { 
        // Reset pointer to display data
        mysqli_data_seek($result, 0);
    ?>
        <div class="stats">
            <span class="total-count">📬 Total messages: <?php echo $totalRows; ?></span>
            <span style="font-size:0.75rem; color:#52647a;">📱 Card view optimized for mobile</span>
        </div>

        <div class="card-grid">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <div class="message-card">
                    <div class="card-header">
                        <span class="id-badge">#<?php echo htmlspecialchars($row['id']); ?></span>
                        <span class="date">📅 <?php echo htmlspecialchars($row['created_at']); ?></span>
                    </div>
                    <div class="card-body">
                        <!-- Full Name -->
                        <div class="info-row">
                            <div class="info-label">👤 Name</div>
                            <div class="info-value">
                                <?php 
                                echo htmlspecialchars($row['first_name'] . " " . $row['last_name']);
                                ?>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="info-row">
                            <div class="info-label">📧 Email</div>
                            <div class="info-value">
                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                                    <?php echo htmlspecialchars($row['email']); ?>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="info-row">
                            <div class="info-label">📞 Phone</div>
                            <div class="info-value">
                                <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>" class="phone-link">
                                    <?php echo htmlspecialchars($row['phone']); ?>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Service -->
                        <div class="info-row">
                            <div class="info-label">🛠️ Service</div>
                            <div class="info-value">
                                <span class="service-chip">
                                    <?php echo htmlspecialchars($row['service']) ?: '—'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- MESSAGE (bottom of card) -->
                        <div class="message-section">
                            <span class="message-label">💬 Message</span>
                            <div class="message-text">
                                <?php 
                                if(empty(trim($row['message']))) {
                                    echo '<span style="color:#9aaebb;">— No message —</span>';
                                } else {
                                    echo nl2br(htmlspecialchars($row['message']));
                                }
                                ?>
                            </div>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end message-card -->
            <?php } ?>
        </div> <!-- end card-grid -->
    <?php 
    } else { 
        // No records
    ?>
        <div class="empty-state">
            <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
            <h3>No messages yet</h3>
            <p style="margin-top: 8px;">Contact form submissions will appear here.</p>
        </div>
    <?php } ?>
</div>

</body>
</html>