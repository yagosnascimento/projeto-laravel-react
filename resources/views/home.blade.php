<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Blog Laravel</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        header { background: #39C5BB; color: white; padding: 20px; text-align: center; }
        .container { width: 80%; margin: 20px auto; }
        .post { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        img { max-width: 100%; border-radius: 5px; }
    </style>
</head>
<body>

<header>
    <h1>Meu Feed de Posts</h1>
</header>

<div class="container">
    {{-- O Blade usa o @foreach para percorrer a lista que o Controller enviou --}}
    @foreach ($posts as $post)
        <div class="post">
            {{-- Exibimos a imagem usando a URL que salvamos no banco --}}
            <img src="{{ $post->image }}" alt="Imagem do Post">
            
            {{-- Exibimos a descrição --}}
            <p>{{ $post->description }}</p>
            
            <small>Postado em: {{ $post->created_at->format('d/m/Y H:i') }}</small>
        </div>
    @endforeach

    {{-- Se a lista estiver vazia, mostramos um aviso --}}
    @if($posts->isEmpty())
        <p>Nenhum post encontrado. Use o Tinker para criar um!</p>
    @endif
</div>

</body>
</html>