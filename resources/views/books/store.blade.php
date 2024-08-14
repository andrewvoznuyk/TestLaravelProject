<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Create Book</h1>
    <form id="bookForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="wrote_at">Wrote At:</label>
        <input type="text" id="wrote_at" name="wrote_at" required>

        <label for="file_path">File Path:</label>
        <input type="text" id="file_path" name="file_path" required>

        <label for="text">Text:</label>
        <textarea id="text" name="text" rows="4" required></textarea>

        <label for="author_id">Author ID:</label>
        <input type="number" id="author_id" name="author_id" required>

        <button type="submit">Create Book</button>
    </form>
</div>

<script>
    document.getElementById('bookForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        try {
            const response = await fetch('http://localhost:8001/api/books/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            alert(result.message || 'Book created successfully');
            document.getElementById('bookForm').reset();
        } catch (error) {
            console.error('Fetch error:', error);
            alert('Error creating book. Please try again.');
        }
    });
</script>
</body>
</html>
