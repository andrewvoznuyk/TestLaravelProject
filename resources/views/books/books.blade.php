<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            margin: auto;
            text-align: center;
        }
        .container > * {
            margin-left: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pagination {
            margin-top: 20px;
            margin-right: 10px;
            text-align: center;
        }
        .pagination button {
            margin: 0 5px;
            padding: 10px 15px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .pagination button.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .pagination button:hover:not(.disabled) {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            margin: 0;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Books List</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <button id="openModalButton">Create New Book</button>
    </div>
    <div class="pagination" id="pagination"></div>
    <div class="output" id="output"></div>
</div>

<div id="bookModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModalButton">&times;</span>
        <h2>Create Book</h2>
        <form id="bookForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="wrote_at">Wrote At:</label>
            <input type="datetime-local" id="wrote_at" name="wrote_at" required>

            <label for="file_path">File Path:</label>
            <input type="text" id="file_path" name="file_path" required>

            <label for="text">Text:</label>
            <textarea id="text" name="text" rows="4" required></textarea>

            <label for="author_id">Author ID:</label>
            <input type="number" id="author_id" name="author_id" required>

            <button type="submit">Create Book</button>
        </form>
    </div>
</div>

<script>
    let currentPage = 1;
    const limit = 10;

    async function fetchBooks(page = 1) {
        const url = `http://localhost:8001/api/books/${page}/${limit}`;

        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            const books = JSON.parse(data.books);
            const totalBooks = data.total;

            let output = '<h2></h2>';
            if (Array.isArray(books) && books.length > 0) {
                output += `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Wrote At</th>
                            <th>File Path</th>
                            <th>Text</th>
                            <th>Publish Houses</th>
                            <th>Author Name</th>
                            <th>Author Email</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
                books.forEach(book => {
                    const truncateText = text => text.split(' ').slice(0, 3).join(' ') + (text.split(' ').length > 3 ? '...' : '');
                    const truncatedText = truncateText(book.text);
                    const truncatedTitle = truncateText(book.title);
                    const truncatedFilePath = truncateText(book.file_path);

                    output += `
                    <tr>
                        <td>${book.id}</td>
                        <td>${book.name}</td>
                        <td>${truncatedTitle}</td>
                        <td>${book.wrote_at}</td>
                        <td>${truncatedFilePath}</td>
                        <td>${truncatedText}</td>
                        <td>${book.publish_house_books.length > 0 ? book.publish_house_books.length : 'None'}</td>
                        <td>${book.author.name}</td>
                        <td>${book.author.email}</td>
                    </tr>
                `;
                });
                output += `
                    </tbody>
                </table>
            `;
            } else {
                output += '<p>No books found.</p>';
            }

            document.getElementById('output').innerHTML = output;
            updatePagination(page, Math.ceil(totalBooks / limit));
        } catch (error) {
            console.error('Fetch error:', error);
            document.getElementById('output').innerHTML = '<p>Error fetching books. Please try again later.</p>';
        }
    }

    function updatePagination(currentPage, totalPages) {
        let paginationHtml = '';

        if (currentPage > 1) {
            paginationHtml += `<button onclick="fetchBooks(${currentPage - 1})">Previous</button>`;
        } else {
            paginationHtml += `<button class="disabled">Previous</button>`;
        }

        if (currentPage < totalPages) {
            paginationHtml += `<button onclick="fetchBooks(${currentPage + 1})">Next</button>`;
        } else {
            paginationHtml += `<button class="disabled">Next</button>`;
        }

        document.getElementById('pagination').innerHTML = paginationHtml;
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchBooks(currentPage);
    });

    const modal = document.getElementById('bookModal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');

    openModalButton.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    document.getElementById('bookForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = {};

        formData.forEach((value, key) => {
            data[key] = value;
        });

        if (data.wrote_at) {
            const localDateTime = data.wrote_at;
            const date = new Date(localDateTime);
            data.wrote_at = formatDateToISO(date);
        }

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
            modal.style.display = 'none';
            await fetchBooks(currentPage);
        } catch (error) {
            console.error('Fetch error:', error);
            alert('Error creating book. Please try again.');
        }
    });

    function formatDateToISO(date) {
        const offset = date.getTimezoneOffset();
        const offsetSign = offset > 0 ? '-' : '+';
        const absOffset = Math.abs(offset);
        const offsetHours = String(Math.floor(absOffset / 60)).padStart(2, '0');
        const offsetMinutes = String(absOffset % 60).padStart(2, '0');
        const offsetString = `${offsetSign}${offsetHours}:${offsetMinutes}`;

        const year = date.getUTCFullYear();
        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
        const day = String(date.getUTCDate()).padStart(2, '0');
        const hours = String(date.getUTCHours()).padStart(2, '0');
        const minutes = String(date.getUTCMinutes()).padStart(2, '0');
        const seconds = String(date.getUTCSeconds()).padStart(2, '0');

        return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}${offsetString}`;
    }

</script>
</body>
</html>
