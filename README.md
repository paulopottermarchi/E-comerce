# 🛒 Marchese Store

Marchese Store é um projeto de e-commerce desenvolvido com Laravel 12 e Bootstrap 5. A loja permite o cadastro de usuários, navegação por produtos, adição ao carrinho, checkout com Stripe e acompanhamento do histórico de pedidos.

---

## 🚀 Funcionalidades

- Autenticação (registro e login)
- Listagem e visualização de produtos
- Carrinho de compras com controle de quantidade
- Integração com [Stripe](https://stripe.com) para pagamento
- Histórico de pedidos do usuário
- Painel de feedback com mensagens de sucesso/erro

---

## 🖥️ Tecnologias Utilizadas

- **Laravel 12**
- **PHP 8.2+**
- **Bootstrap 5**
- **MySQL**
- **Stripe API**
- **Pinggy** (para testes com webhooks locais)

---

## 📦 Instalação

```bash
git clone https://github.com/seu-usuario/marchese-store.git
cd marchese-store

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate
