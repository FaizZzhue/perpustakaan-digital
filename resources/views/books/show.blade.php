<!DOCTYPE html>
<html>
<head>
    <title>Detail Buku</title>
</head>
<body>

    <h1>{{ $book->title }}</h1>

    <p>Penulis: {{ $book->author }}</p>

    <p>Kategori: {{ $book->category }}</p>

    <p>Stok: {{ $book->stock }}</p>

    <a href="{{ route('books.index') }}">
        Kembali
    </a>

</body>
</html>