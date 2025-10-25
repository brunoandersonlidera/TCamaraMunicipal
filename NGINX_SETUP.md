# 🚀 Configuração Nginx + Laravel - Porta 80 (IP Público)

## 📋 Pré-requisitos

- **Windows** com PowerShell
- **Nginx** instalado em `C:\nginx-1.28.0`
- **PHP** com php-cgi disponível no PATH
- **Privilégios de Administrador** (obrigatório para porta 80)

## 🔧 Configuração Inicial

### 1. **Configurar Firewall (OBRIGATÓRIO)**
```powershell
# Execute como Administrador
.\configurar-firewall.ps1
```

### 2. **Verificar Configurações**
- ✅ Nginx em: `C:\nginx-1.28.0`
- ✅ Projeto em: `D:\APLIC\TCamaraMunicipal`
- ✅ PHP-CGI disponível no PATH

## 🚀 Como Usar

### **Iniciar Servidor**
```powershell
# Execute como Administrador (obrigatório para porta 80)
.\start-laravel-nginx.ps1
```

### **Parar Servidor**
```powershell
.\stop-laravel-nginx.ps1
```

## 🌐 Acesso ao Sistema

### **Local**
- 🔗 http://localhost
- 🔗 http://127.0.0.1

### **Domínio Público**
- 🔗 http://camara.lidera.app.br
- ⚠️ Requer configuração DNS (veja `docs/CONFIGURACAO_DNS.md`)

### **Rede Local**
- 🔗 http://[IP_DA_MAQUINA]
- Exemplo: http://192.168.1.100

### **Descobrir IP da Máquina**
```powershell
ipconfig | findstr "IPv4"
```

## ⚙️ Configurações

### **Nginx**
- **Porta:** 80 (IP público 0.0.0.0)
- **Domínio:** camara.lidera.app.br
- **Configuração:** `nginx-laravel.conf`
- **Logs:** `C:\nginx-1.28.0\logs\`

### **PHP-CGI**
- **Porta:** 9000 (apenas localhost)
- **Protocolo:** FastCGI

## 🔒 Segurança

### **Firewall**
- ✅ Porta 80: Aberta para conexões externas
- ✅ Porta 9000: Restrita ao localhost
- ✅ Regras automáticas criadas pelo script

### **Acesso Externo**
Para permitir acesso externo (internet), configure:
1. **Router:** Port forwarding da porta 80
2. **DNS:** Apontar domínio para o IP público
3. **SSL:** Configurar certificado HTTPS (recomendado)

## 🛠️ Solução de Problemas

### **Erro: "Porta 80 em uso"**
```powershell
# Verificar quem está usando a porta 80
netstat -ano | findstr ":80.*LISTENING"

# Parar IIS (se estiver rodando)
iisreset /stop

# Parar outros serviços web
net stop w3svc
```

### **Erro: "Acesso negado"**
- ✅ Execute PowerShell como **Administrador**
- ✅ Execute o script `configurar-firewall.ps1`

### **Erro: "Nginx não inicia"**
```powershell
# Verificar logs do Nginx
Get-Content "C:\nginx-1.28.0\logs\error.log" -Tail 20

# Testar configuração
C:\nginx-1.28.0\nginx.exe -t
```

### **Erro: "PHP-CGI não responde"**
```powershell
# Verificar se PHP está no PATH
php-cgi -v

# Verificar se a porta 9000 está livre
netstat -an | findstr ":9000"
```

## 📁 Estrutura de Arquivos

```
TCamaraMunicipal/
├── start-laravel-nginx.ps1    # Iniciar servidor
├── stop-laravel-nginx.ps1     # Parar servidor
├── configurar-firewall.ps1    # Configurar firewall
├── nginx.conf                 # Configuração principal do Nginx
├── nginx-laravel.conf         # Configuração específica do Laravel
└── NGINX_SETUP.md            # Esta documentação
```

## 🔄 Processo de Inicialização

1. **Verificação de privilégios** administrativos
2. **Verificação de disponibilidade** da porta 80
3. **Cópia de configurações** para o Nginx
4. **Parada de processos** existentes
5. **Inicialização do PHP-CGI** na porta 9000
6. **Inicialização do Nginx** na porta 80
7. **Verificação de funcionamento**

## 📊 Monitoramento

### **Verificar Status**
```powershell
# Processos rodando
Get-Process | Where-Object {$_.ProcessName -like "*nginx*" -or $_.ProcessName -like "*php*"}

# Portas em uso
netstat -an | findstr ":80\|:9000"

# Logs em tempo real
Get-Content "C:\nginx-1.28.0\logs\laravel-access.log" -Wait
Get-Content "C:\nginx-1.28.0\logs\laravel-error.log" -Wait
```

## 🌐 Configuração DNS

Para usar o domínio `camara.lidera.app.br`, você precisa configurar o DNS:

1. **Consulte:** `docs/CONFIGURACAO_DNS.md` para instruções detalhadas
2. **Configure:** Registro A no provedor do domínio `lidera.app.br`
3. **Aponte:** Para o IP público do servidor
4. **Aguarde:** Propagação DNS (até 48 horas)

## 🎯 Próximos Passos

1. **DNS:** Configurar subdomínio camara.lidera.app.br (veja `docs/CONFIGURACAO_DNS.md`)
2. **SSL/HTTPS:** Configurar certificado SSL para o domínio
3. **Load Balancer:** Para múltiplas instâncias
4. **Backup:** Automatizar backup das configurações

---

*Para suporte técnico, verifique os logs em `C:\nginx-1.28.0\logs\` ou execute os comandos de diagnóstico acima.*