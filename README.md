## 1. O que é o projeto?
Ser um desenvolvedor não é apenas ser um pedreiro de código. O trabalho de um desenvolvedor é sempre solucionar problemas. Por isso, me esforcei nesse projeto para criar um projeto em Laravel e React (vite) para criar um blog utilizando não apenas código, mas também Trello e Figma para poder estruturar em um trabalho digno.

Trello: https://trello.com/b/91qaRJYB/blog-laravel-hub <br>
Figma: https://www.figma.com/design/xjcMp1s5urL44I1Qndb44l/Blog-Laravel?node-id=0-1&t=ybSEMko3L990ONBS-1



### Criando o projeto
Para começar, você precisa de três coisas no seu PC:
1.  **PHP:** O interpretador da linguagem.
2.  **Composer:** O gerenciador de pacotes (como o NuGet do C# ou o pip do Python).
3.  **VS Code:** (Ou qualquer editor que você curta).


## 2. Sintaxe Básica (Onde tudo começa)

Todo arquivo PHP precisa começar com a tag `<?php`. Você não precisa fechar essa tag se o arquivo só contiver código PHP.

### Variáveis e Tipos
No PHP, toda variável começa com um cifrão `$`. O PHP é fracamente tipado (embora esteja ficando cada vez mais rigoroso).

```php
<?php

$titulo = "Meu Primeiro Blog"; // String
$postagens = 10;               // Integer
$estaAtivo = true;             // Boolean

// Para exibir algo na tela, usamos o 'echo'
echo "Bem-vindo ao " . $titulo; 
```
Note que usamos o . para concatenar strings, e não o sinal de +.

## 3. Arrays (A alma do PHP)

No PHP, os arrays são extremamente poderosos. Eles podem ser listas simples ou "mapas" (chave => valor), que chamamos de Arrays Associativos.

```php
<?php

// Array simples
$categorias = ["Tecnologia", "Games", "3D Printing"];

// Array associativo (muito comum para dados de banco)
$post = [
    "titulo" => "Aprendendo PHP em 2026",
    "descricao" => "Um guia para iniciantes",
    "imagem" => "banner.jpg"
];

echo $post["titulo"]; // Saída: Aprendendo PHP em 2026
```

## 4. Estruturas de Controle

Como você já tem noção de lógica, aqui é bem parecido com o que você já conhece:

### Condicionais
```php
if ($postagens > 0) {
    echo "Temos conteúdo!";
} else {
    echo "Blog vazio.";
}
```

### Loops (Essencial para o Blog)
O `foreach` é o seu melhor amigo para listar as postagens na tela.

```php
$posts = ["Post 1", "Post 2", "Post 3"];

foreach ($posts as $item) {
    echo "<li>" . $item . "</li>";
}
```

## 5. O Próximo Passo: Funções

Para o seu projeto de blog, você vai precisar organizar o código em funções. Uma função simples em PHP:

```php
function formatarData($data) {
    return date('d/m/Y', strtotime($data));
}
```
## 6. Criando um projeto em Laravel

Para iniciar o projeto, precisamos ter o composer instalado e iniciar o projeto com o comando:
```bash
composer create-project laravel/laravel meu-blog
```

Assim que ele terminar de baixar uma tonelada de pastas, entre no diretório:
```bash
cd meu-blog
```

## 7. Configurando o SQLite

O Laravel é muito inteligente. Ele já vem com o SQLite configurado como padrão! 
Abra a pasta do projeto no VsCode.
Procure pelo arquivo chamado .env na raiz. É nele que ficam as configurações "sensíveis" (como conexão de banco de dados).
Verifique se as linhas do banco de dados estão assim:
```php
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, etc., podem ser apagados ou comentados, 
# pois o SQLite só precisa do driver.
```

## 8. Entendendo a "Engrenagem" (O fluxo da requisição)

Antes de codar, saca só como o Laravel organiza as coisas. Diferente do PHP puro onde você abre um arquivo .php direto, aqui tudo passa por uma "recepção".
- Routes (routes/web.php): É o mapa. "Se o usuário digitar /blog, mande para tal lugar".
- Controller: É o cérebro. Ele busca a imagem e a descrição no banco.
- View (Blade): É a cara do projeto. Ele recebe os dados do Controller e monta o HTML.

## 9. O "Esqueleto" de Dados (Migration e Model)

No Laravel, a gente não abre o SQLite e cria tabela manualmente. A gente cria um arquivo de código chamado Migration, que diz ao banco de dados como ele deve ser.
No terminal, digite:
```bash
php artisan make:model Post-m
```
O que aconteceu aqui?
- make:model Post: Criou um arquivo chamado Post.php em app/Models. Ele é o representante dessa tabela dentro do código PHP.
- -m: Esse é o "pulo do gato". Ele gera automaticamente o arquivo de *Migration*! (A planta da tabela).

## 10. Editando a migração

Vá em database/migrations e abra o arquivo novo que foi criado. Ele vem com um código já padrão, então vamos nossas colunas em up!
```php
public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id(); // Cria uma chave primária (ID) que aumenta sozinha
        $table->string('image'); // Uma coluna de texto para guardar o caminho/link da imagem
        $table->text('description'); // Uma coluna de texto longo para a descrição
        $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at' automaticamente
    });
}
```
Por que fizemos isso?
Definimos que cada post terá obrigatoriamente um ID, um caminho para imagem e um texto. Agora, vamos "dar o play" para criar a tabela de verdade no SQLite:
```
php artisan migrate
```
Se ele perguntar se deseja criar o arquivo database.sqlite, digite yes.

## 11. O "Cerebro" (Controller)

O banco existe, mas quem vai buscar os dados lá e mandar pra tela? É o Controller.
Rode:
```bash
php artisan make:controller PostController
```
Vá em app/Http/Controllers/PostController.php e adicione uma função (método) para listar os posts:
```php
<?php

namespace App\Http\Controllers;

use App\Models\Post; // Importante: avisamos o PHP que vamos usar o modelo Post
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Pegamos todos os registros da tabela 'posts' no SQLite
        $posts = Post::all();

        // Enviamos esses dados para a view chamada 'home' 
        // dentro da variável 'posts'
        return view('home', ['posts' => $posts]);
    }
}
```
O que essa linha Post::all() faz?
Ela executa um SELECT * FROM posts no banco de dados de forma automática. O Laravel cuida de toda a tradução.

## 12. O "Mapa" (Rota)

Precisamos dizer ao Laravel que, quando alguém acessar o site, ele deve chamar o index do nosso PostController. Para isso, abra o routes/web.php e vamos mudar o código:
```php
<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Quando o usuário acessar a raiz '/', o PostController executa o método 'index'
Route::get('/', [PostController::class, 'index']);
```

## 13. O View com Blade (A cara do blog)

O controller mandou os dados para uma view chamada home. Vamos criá-la. Vá em resources/views, apague o welcome.blade.php e crie o home.blade.php.
Coloque esse código simples:
```php
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
```

## 14. Criando o primeiro dado, o teste real
Se você rodar o site agora (php artisan serve), ele vai estar vazio. Vamos usar uma ferramenta do Laravel chamada Tinker para inserir um post rapidinho via terminal, só para ver se funciona:
```bash
php artisan tinker
```
Agora digite esses comandos um por um:
```php
$p = new App\Models\Post;
$p->image = "https://img.itdg.com.br/tdg/images/blog/uploads/2023/04/pudim-de-leite-condensado.jpg";
$p->description = "Este é o meu primeiro post no Laravel usando SQLite!";
$p->save();
```
Depois digite exit para sair do Tinker.

---
