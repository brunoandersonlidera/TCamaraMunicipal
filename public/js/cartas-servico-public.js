// Alias de compatibilidade para evitar erro de recurso ausente no módulo Cartas de Serviço.
// Se necessário, mover lógica específica para este arquivo ou importar de cartas-servico.js.
(function(){
  // No-op: apenas evita 404 e mantém a página funcional.
  if (window && !window.__cartasServicoPublicLoaded) {
    window.__cartasServicoPublicLoaded = true;
    try {
      console.debug('cartas-servico-public.js carregado (stub).');
    } catch (e) {}
  }
})();