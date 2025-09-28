<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Paginação - Novos Estilos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding: 2rem;
        }
        .demo-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .demo-title {
            color: #495057;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Demonstração dos Novos Estilos de Paginação</h1>
        
        <div class="demo-container">
            <h3 class="demo-title">
                <i class="fas fa-list me-2"></i>
                Paginação com Muitas Páginas
            </h3>
            
            <!-- Simulando paginação com muitas páginas -->
            <nav aria-label="Navegação de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Anterior</span>
                        </span>
                    </li>
                    <li class="page-item active">
                        <span class="page-link">1</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">10</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <span class="d-none d-sm-inline me-1">Próximo</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="demo-container">
            <h3 class="demo-title">
                <i class="fas fa-mobile-alt me-2"></i>
                Paginação Responsiva (Mobile)
            </h3>
            
            <!-- Simulando paginação responsiva -->
            <nav aria-label="Navegação de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Anterior</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item active">
                        <span class="page-link">3</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <span class="d-none d-sm-inline me-1">Próximo</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="demo-container">
            <h3 class="demo-title">
                <i class="fas fa-info-circle me-2"></i>
                Características dos Novos Estilos
            </h3>
            
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-check-circle text-success me-2"></i>Melhorias Implementadas:</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Botões com bordas arredondadas</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Efeitos de hover suaves</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Ícones nos botões anterior/próximo</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Cores consistentes com o tema</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Animações de transição</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-mobile-alt text-info me-2"></i>Responsividade:</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Texto oculto em telas pequenas</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Botões menores em mobile</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Espaçamento otimizado</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Efeito shimmer para carregamento</li>
                        <li><i class="fas fa-arrow-right text-primary me-2"></i>Animação de entrada</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="/admin/eventos" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar para Eventos Administrativos
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>