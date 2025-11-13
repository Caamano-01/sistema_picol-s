# 🍦 Sistema de Gerenciamento de Produção e Vendas de Picolés

## 📋 Descrição do Projeto

Este projeto consiste em uma aplicação web completa (front-end e back-end) para o gerenciamento da **produção, estoque e vendas** de uma empresa **fabricante de picolés**.

O sistema permite:
- Cadastrar sabores, ingredientes e tipos de picolé;
- Criar lotes de produção;
- Emitir notas fiscais de venda;
- Controlar revendedores;
- Gerar relatórios e gráficos de vendas.

O projeto foi desenvolvido com **PHP** no back-end, **MySQL** como banco de dados, e **HTML/CSS/JS** com **Bootstrap** e no front-end.

---

## 🧱 Estrutura da Aplicação

A aplicação está dividida em **4 módulos principais**:

### 1. Módulo de Cadastros
Permite o gerenciamento das informações básicas:
- **Sabores**
- **Ingredientes**
- **Tipos de Embalagem**
- **Aditivos Nutritivos**
- **Conservantes**
- **Revendedores**

### 2. Módulo de Produção
Permite:
- **Cadastro de picolés** (normais ou ao leite)
- **Associação de ingredientes, aditivos e conservantes**
- **Criação de lotes de produção**

### 3. Módulo de Vendas
Funcionalidades:
- **Emissão de Notas Fiscais**
- **Vinculação de lotes e revendedores**
- **Listagem e detalhes de notas fiscais**

### 4. Módulo de Relatórios
Relatórios disponíveis:
- **Vendas mensais por tipo de picolé**
- **Ranking de revendedores que mais compraram**
- **Gráficos interativos com Chart.js**

---

## 🗄️ Modelagem e Banco de Dados

### Banco de Dados: `MySQL`
O banco contém as principais tabelas:

- `sabor`
- `ingrediente`
- `embalagem`
- `aditivo_nutritivo`
- `conservante`
- `revendedor`
- `picole`
- `lote`
- `nota_fiscal`
- `nota_lote`

As relações entre picolés, ingredientes e lotes são feitas através de chaves estrangeiras.  
