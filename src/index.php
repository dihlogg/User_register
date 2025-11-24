<?php require 'db.php'; 
$success = $error = '';

// Danh sách câu hỏi bảo mật
$security_questions = [
    "What is your mother's maiden name?",
    "What was the name of your first pet?",
    "What is your favorite movie?",
    "In which city were you born?",
    "What is the name of your primary school?"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Creation Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card { max-width: 800px; margin: 2rem auto; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .form-label { font-weight: 600; color: #333; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Account Creation Request</h3>
        </div>
        <div class="card-body p-4">
            <?php if($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post" novalidate>
                <div class="row g-3">
                    <!-- First Name & Last Name -->
                    <div class="col-md-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>

                    <!-- Email & Phone -->
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <!-- Date of Birth & Gender -->
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Address & Country -->
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control">
                    </div>

                    <!-- Security Question -->
                    <div class="col-md-7">
                        <label class="form-label">Security Question <span class="text-danger">*</span></label>
                        <select name="security_question" class="form-select" required>
                            <option value="">Select a question</option>
                            <?php foreach($security_questions as $q): ?>
                                <option value="<?= htmlspecialchars($q) ?>"><?= htmlspecialchars($q) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Security Answer <span class="text-danger">*</span></label>
                        <input type="text" name="security_answer" class="form-control" required>
                    </div>

                    <!-- Referral Code -->
                    <div class="col-12">
                        <label class="form-label">Referral Code (Optional)</label>
                        <input type="text" name="referral_code" class="form-control">
                    </div>

                    <!-- Preferences -->
                    <div class="col-12">
                        <label class="form-label">Preferences:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="preferences[]" value="newsletter" id="news">
                            <label class="form-check-label" for="news">Subscribe to Newsletter</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="preferences[]" value="updates" id="upd">
                            <label class="form-check-label" for="upd">Receive Product Updates</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="preferences[]" value="offers" id="off">
                            <label class="form-check-label" for="off">Get Promotional Offers</label>
                        </div>
                    </div>

                    <!-- Account Type -->
                    <div class="col-12 mt-3">
                        <label class="form-label">Account Type:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="account_type" value="Personal" id="personal" checked>
                            <label class="form-check-label" for="personal">Personal Account</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="account_type" value="Business" id="business">
                            <label class="form-check-label" for="business">Business Account</label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Create Account</button>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <a href="list.php" class="btn btn-outline-secondary">View All Registrations</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if ($_POST) {
    try {
        // Lấy dữ liệu
        $first_name         = trim($_POST['first_name'] ?? '');
        $last_name          = trim($_POST['last_name'] ?? '');
        $email              = trim($_POST['email'] ?? '');
        $security_question  = $_POST['security_question'] ?? '';
        $security_answer    = trim($_POST['security_answer'] ?? '');

        if (!$first_name || !$last_name || !$email || !$security_question || !$security_answer) {
            throw new Exception("Please fill all required fields.");
        }

        // Xử lý checkbox preferences
        $prefs = $_POST['preferences'] ?? [];
        $newsletter = in_array('newsletter', $prefs) ? 1 : 0;
        $updates    = in_array('updates', $prefs) ? 1 : 0;
        $offers     = in_array('offers', $prefs) ? 1 : 0;

        $stmt = $pdo->prepare("INSERT INTO users (
            first_name, last_name, email, phone, dob, gender, address, country,
            security_question, security_answer, referral_code,
            subscribe_newsletter, receive_updates, promotional_offers, account_type
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $first_name,
            $last_name,
            $email,
            $_POST['phone'] ?? null,
            $_POST['dob'] ?? null,
            $_POST['gender'] ?? null,
            $_POST['address'] ?? null,
            $_POST['country'] ?? null,
            $security_question,
            $security_answer,
            $_POST['referral_code'] ?? null,
            $newsletter,
            $updates,
            $offers,
            $_POST['account_type'] ?? 'Personal'
        ]);

        $success = "Account created successfully! Thank you, " . htmlspecialchars($first_name) . ".";
        
        // Reset form (tùy bạn)
        $_POST = [];
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

</body>
</html>