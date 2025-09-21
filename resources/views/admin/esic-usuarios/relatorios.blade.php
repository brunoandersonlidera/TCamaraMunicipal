@extends('layouts.admin')

@section('title', 'Relatórios - Usuários E-SIC')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Relatórios - Usuários E-SIC
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Funcionalidade de relatórios em desenvolvimento.
                            </p>
                            
                            <div class="alert alert-info">
                                <h5><i class="fas fa-tools"></i> Em Desenvolvimento</h5>
                                <p>Esta seção conterá relatórios detalhados sobre:</p>
                                <ul>
                                    <li>Estatísticas de cadastros por período</li>
                                    <li>Taxa de verificação de e-mail</li>
                                    <li>Usuários mais ativos</li>
                                    <li>Relatórios de manifestações por usuário</li>
                                    <li>Exportação de dados (Excel, PDF)</li>
                                </ul>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('admin.esic-usuarios.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    Voltar para Lista de Usuários
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection