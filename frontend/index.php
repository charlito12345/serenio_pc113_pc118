<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f4;">
    <div style="background-color: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 300px;">
        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Login</h2>
        <form method="POST" action="">
            <label for="username" style="font-size: 14px; color: #555; display: block; margin-bottom: 8px;">Username</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; font-size: 14px;">

            <label for="password" style="font-size: 14px; color: #555; display: block; margin-bottom: 8px;">Password</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 20px; font-size: 14px;">

            <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;">Login</button>
        </form>
    </div>
</body>
</html>
