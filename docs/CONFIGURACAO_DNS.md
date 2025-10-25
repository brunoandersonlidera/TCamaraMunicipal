# 🌐 Configuração DNS - Subdomínio camara.lidera.app.br

## 📋 Visão Geral

Este documento detalha como configurar o DNS para que o subdomínio `camara.lidera.app.br` aponte para o servidor onde está rodando o sistema da Câmara Municipal.

## 🎯 Objetivo

Configurar o subdomínio `camara.lidera.app.br` para acessar o sistema Laravel através do Nginx na porta 80.

## 🔧 Configurações Necessárias

### 1. **Configuração DNS (Provedor de Domínio)**

No painel de controle do seu provedor de domínio `lidera.app.br`, adicione os seguintes registros DNS:

#### **Registro A (Recomendado)**
```
Tipo: A
Nome: camara
Valor: [IP_PUBLICO_DO_SERVIDOR]
TTL: 3600 (1 hora)
```

#### **Registro CNAME (Alternativo)**
```
Tipo: CNAME
Nome: camara
Valor: lidera.app.br
TTL: 3600 (1 hora)
```

### 2. **Descobrir IP Público do Servidor**

```powershell
# Método 1: Via PowerShell
Invoke-RestMethod -Uri "https://ipinfo.io/ip"

# Método 2: Via navegador
# Acesse: https://whatismyipaddress.com/
```

### 3. **Configuração do Nginx** ✅

O Nginx já está configurado para aceitar o subdomínio:

```nginx
server {
    listen 0.0.0.0:80;
    server_name camara.lidera.app.br localhost _;
    # ... resto da configuração
}
```

## 🌍 Exemplos de Configuração por Provedor

### **Cloudflare**
1. Acesse o painel do Cloudflare
2. Selecione o domínio `lidera.app.br`
3. Vá em **DNS** > **Records**
4. Clique em **Add record**
5. Configure:
   - **Type:** A
   - **Name:** camara
   - **IPv4 address:** [IP_DO_SERVIDOR]
   - **Proxy status:** 🟠 DNS only (recomendado inicialmente)

### **GoDaddy**
1. Acesse o painel GoDaddy
2. Vá em **Meus Produtos** > **DNS**
3. Clique em **Adicionar** novo registro
4. Configure:
   - **Tipo:** A
   - **Host:** camara
   - **Aponta para:** [IP_DO_SERVIDOR]
   - **TTL:** 1 hora

### **HostGator**
1. Acesse o cPanel
2. Vá em **Zone Editor**
3. Selecione o domínio `lidera.app.br`
4. Clique em **Add Record**
5. Configure:
   - **Type:** A
   - **Name:** camara
   - **Address:** [IP_DO_SERVIDOR]

## 🔍 Verificação da Configuração

### **1. Teste DNS**
```powershell
# Verificar resolução DNS
nslookup camara.lidera.app.br

# Verificar propagação DNS
nslookup camara.lidera.app.br 8.8.8.8
```

### **2. Teste de Conectividade**
```powershell
# Testar conexão HTTP
Test-NetConnection -ComputerName camara.lidera.app.br -Port 80

# Via curl (se disponível)
curl -I http://camara.lidera.app.br
```

### **3. Teste no Navegador**
- Acesse: http://camara.lidera.app.br
- Deve carregar o sistema da Câmara Municipal

## ⏱️ Tempo de Propagação

| Tipo de Alteração | Tempo Estimado |
|-------------------|----------------|
| Novo registro A   | 1-4 horas      |
| Alteração de IP   | 4-24 horas     |
| Propagação global | 24-48 horas    |

## 🛠️ Solução de Problemas

### **DNS não resolve**
```powershell
# Limpar cache DNS local
ipconfig /flushdns

# Testar com DNS público
nslookup camara.lidera.app.br 8.8.8.8
nslookup camara.lidera.app.br 1.1.1.1
```

### **Site não carrega**
1. ✅ Verificar se Nginx está rodando: `.\start-laravel-nginx.ps1`
2. ✅ Verificar firewall: `.\configurar-firewall.ps1`
3. ✅ Verificar logs: `C:\nginx-1.28.0\logs\laravel-error.log`

### **Erro "Site não pode ser alcançado"**
- Verificar se o IP público está correto
- Verificar se a porta 80 está aberta no firewall
- Verificar se o roteador permite port forwarding (se necessário)

## 🔒 Configurações de Segurança

### **Firewall do Servidor**
```powershell
# Verificar regras existentes
netsh advfirewall firewall show rule name="Laravel Nginx HTTP"

# Recriar regras se necessário
.\configurar-firewall.ps1
```

### **Port Forwarding (se necessário)**
Se o servidor estiver atrás de um roteador/NAT:
1. Acesse o painel do roteador
2. Configure port forwarding:
   - **Porta externa:** 80
   - **Porta interna:** 80
   - **IP interno:** [IP_LOCAL_DO_SERVIDOR]

## 📊 Monitoramento

### **Verificar Status do Domínio**
```powershell
# Script de monitoramento
$response = Invoke-WebRequest -Uri "http://camara.lidera.app.br" -UseBasicParsing
Write-Host "Status: $($response.StatusCode)" -ForegroundColor Green
```

### **Logs de Acesso**
```powershell
# Monitorar acessos em tempo real
Get-Content "C:\nginx-1.28.0\logs\laravel-access.log" -Wait | Where-Object {$_ -like "*camara.lidera.app.br*"}
```

## 🎯 Próximos Passos

1. **SSL/HTTPS:** Configurar certificado SSL para `https://camara.lidera.app.br`
2. **CDN:** Configurar Cloudflare ou similar para melhor performance
3. **Backup DNS:** Configurar registros de backup
4. **Monitoramento:** Implementar alertas de disponibilidade

## 📞 Suporte

Para problemas relacionados ao DNS:
1. Verifique as configurações no provedor do domínio
2. Aguarde o tempo de propagação (até 48h)
3. Use ferramentas online como `whatsmydns.net` para verificar propagação global

---

*Última atualização: $(Get-Date -Format "dd/MM/yyyy HH:mm")*