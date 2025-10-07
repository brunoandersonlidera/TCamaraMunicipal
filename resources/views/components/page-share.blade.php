<div class="page-share-footer border-top pt-3 mt-3 text-center">
    <span class="me-2">Compartilhar:</span>
    @php
        $url = urlencode(request()->fullUrl());
        $title = isset($titulo) ? urlencode($titulo) : urlencode(config('app.name'));
    @endphp
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
       target="_blank" class="btn btn-sm btn-outline-primary me-1" aria-label="Compartilhar no Facebook">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
       target="_blank" class="btn btn-sm btn-outline-dark me-1" aria-label="Compartilhar no X">
        <i class="fab fa-twitter"></i>
    </a>
    <a href="https://wa.me/?text={{ $title }}%20-%20{{ $url }}"
       target="_blank" class="btn btn-sm btn-outline-success me-1" aria-label="Compartilhar no WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}"
       target="_blank" class="btn btn-sm btn-outline-primary me-1" aria-label="Compartilhar no LinkedIn">
        <i class="fab fa-linkedin-in"></i>
    </a>
    <a href="mailto:?subject={{ $title }}&body={{ $title }}%20-%20{{ $url }}"
       class="btn btn-sm btn-outline-secondary" aria-label="Compartilhar por E-mail">
        <i class="fas fa-envelope"></i>
    </a>
    <button type="button" class="btn btn-sm btn-outline-danger ms-1" aria-label="Compartilhar no Instagram"
            onclick="shareOnInstagram('{{ isset($titulo) ? $titulo : config('app.name') }}', '{{ request()->fullUrl() }}')">
        <i class="fab fa-instagram"></i>
    </button>
</div>
<script>
// Instagram não possui um web intent oficial para compartilhar links diretamente.
// Tentamos usar o Web Share API quando disponível; caso contrário, copiamos o link
// e orientamos o usuário a colá-lo no Story usando o sticker de link.
(function(){
  if (!window.shareOnInstagram) {
    window.shareOnInstagram = function(title, url) {
      const shareData = { title: title, text: title, url: url };
      if (navigator.share) {
        navigator.share(shareData).catch(function(){ /* silencioso */ });
        return;
      }
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function(){
          alert('Link copiado! Abra o Instagram e use o sticker de link no Story.');
        }).catch(function(){
          prompt('Copie o link para compartilhar no Instagram:', url);
        });
      } else {
        prompt('Copie o link para compartilhar no Instagram:', url);
      }
      // Em iOS, podemos abrir o criador de Story do Instagram via universal link (se o app estiver instalado)
      const isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
      if (isiOS) {
        // Isso apenas abre o Instagram; o link deve ser adicionado pelo usuário via sticker
        window.location.href = 'https://www.instagram.com/create/story';
      }
    };
  }
})();
</script>