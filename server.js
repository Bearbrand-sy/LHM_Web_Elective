const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();
const PORT = 3000;

// Middleware to parse form data
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Serve static files (your HTML, CSS, JS)
app.use(express.static('public'));

// POST route to save account
app.post('/signup', (req, res) => {
  const { username, email, password } = req.body;
  const entry = `Username: ${username}, Email: ${email}, Password: ${password}\n`;

  fs.appendFile('users.txt', entry, (err) => {
    if (err) {
      console.error('Error saving account:', err);
      return res.status(500).send('Failed to save account.');
    }
    res.send('Account saved successfully.');
  });
});

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
