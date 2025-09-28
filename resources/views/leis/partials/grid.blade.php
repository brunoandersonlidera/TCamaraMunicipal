@foreach($leis as $lei)
    <div class="lei-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="lei-card-header">
            <div class="lei-tipo">
                <span class="badge badge-tipo badge-{{ Str::slug($lei->tipo) }}">
                    {{ $lei->tipo }}
                </span>
            </div>
            <div class="lei-numero">
                {{ $lei->numero_formatado }}
            </div>
        </div>
        
        <div class="lei-card-body">
            <h3 class="lei-titulo">
                <a href="{{ route('leis.show', $lei->slug) }}">
                    {{ $lei->titulo }}
                </a>
            </h3>
            
            <div class="lei-meta">
                <div class="lei-data">
                    <i class="fas fa-calendar"></i>
                    {{ $lei->data->format('d/m/Y') }}
                </div>
                @if($lei->autoria)
                    <div class="lei-autoria">
                        <i class="fas fa-user"></i>
                        {{ $lei->autoria }}
                    </div>
                @endif
            </div>
            
            <div class="lei-descricao">
                {{ Str::limit($lei->descricao, 200) }}
            </div>
        </div>
        
        <div class="lei-card-footer">
            <div class="lei-acoes">
                <a href="{{ route('leis.show', $lei->slug) }}" 
                   class="btn btn-primary btn-sm">
                    <i class="fas fa-eye"></i>
                    Ver detalhes
                </a>
                
                @if($lei->temArquivoPdf())
                    <a href="{{ $lei->getUrlPdf() }}" 
                       target="_blank" 
                       class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-pdf"></i>
                        PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
@endforeach