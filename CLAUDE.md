# TwoClicks v2 — Contexto do Projeto

**Última atualização:** 23/02/2026

---

## 1. Papéis e Metodologia

### 1.1 Divisão de Papéis

| Papel | Quem | Responsabilidade |
|-------|------|-----------------|
| **Gerente de Projeto** | Claude (chat) | Documenta, organiza, gera prompts detalhados, valida resultados |
| **Programador** | Claude Code | Executa os prompts, coda, roda comandos |
| **Product Owner** | Alex (humano) | Define requisitos, aprova entregas, testa |

**Regra:** O Chat NUNCA coda diretamente. Ele gera prompts para o Claude Code executar.

### 1.2 Metodologia de Trabalho

1. **1 prompt = 1 tarefa pequena.** Nunca mandar tudo de uma vez.
2. **Instruções explícitas:** sempre incluir "Siga EXATAMENTE o código abaixo. Não adicione, remova ou renomeie NENHUM campo por conta própria."
3. **Validação pós-execução:** após cada tarefa, pedir para mostrar o resultado.
4. **Finalização:** "Não altere mais nada."

### 1.3 Formato dos Prompts

- **Granularidade:** Prompts pequenos e sequenciais
- **Formato:** Blockquote (`>`) para o Alex copiar e colar no Claude Code
- **Idioma:** Português
- **Padrão:** Contexto → Instrução → Código exato → Validação esperada → "Não altere mais nada"

---

## 2. Visão Geral do Projeto

O TwoClicks v2 é uma **plataforma multi-tenant** que gerencia múltiplos produtos SaaS. Cada produto é uma "platform" com seus próprios tenants.

### Hierarquia

```
TwoClicks (global)
└── Platforms (ex: SmartClick360, ApDireta, Bethel360)
    └── Tenants (empresas clientes de cada platform)
```

### Terminologia

| Termo | Significado |
|-------|-------------|
| **Global** | Nível TwoClicks — gerencia platforms |
| **Platform** | Produto SaaS (ex: SmartClick360) |
| **Tenant** | Empresa cliente de uma platform |

### Stack Tecnológica

| Camada | Tecnologia |
|--------|-----------|
| Framework | Laravel 11 |
| PHP | 8.4 |
| Frontend | Blade Templates |
| Tema | Metronic 8 Demo 34 |
| Banco de Dados | PostgreSQL 17 |
| CSS | Bootstrap 5 |
| Ícones | KTIcons |
| Máscaras | Inputmask.js |
| Servidor Local | Laravel Herd |
| Controle de Versão | Git + GitHub |

### Caminhos Locais

- **Projeto Laravel:** `C:\Herd\twoclicks-v2`
- **Metronic (SOMENTE LEITURA):** `C:\Herd\themeforest\metronic\demo34`
- **URL local:** `http://twoclicks-v2.test`

---

## 3. Arquitetura de Bancos de Dados

### Estratégia: Database-per-Tenant (3 níveis)

| Nível | Banco | Conexão | Finalidade |
|-------|-------|---------|-----------|
| Global | `tc_main` | `global` | Gerencia platforms, configurações do sistema |
| Platform | `{slug_platform}_main` | `platform` | Gerencia tenants da platform |
| Tenant | `{slug_platform}_{slug_tenant}` | `tenant` | Dados do cliente |

### Conexão Atual (config/database.php)

```php
'global' => [
    'driver'   => 'pgsql',
    'database' => env('DB_DATABASE', 'tc_main'),
    'schema'   => 'public',
]
```

`.env`: `DB_CONNECTION=global`

---

## 4. Estrutura de Banco de Dados (tc_main)

### 4.1 Tabelas do Sistema Modular (7 tabelas)

#### modules (27 campos)
- id, name, slug (unique), type (default 'module'), scope (obrigatório: tenant/landlord)
- icon (nullable), model (nullable), service (nullable), controller (nullable)
- show_drag (true), show_checkbox (true), show_actions (true)
- default_sort_field ('id'), default_sort_direction ('asc'), per_page (25)
- view_index (nullable), view_show (nullable), view_modal (nullable)
- after_store ('index'), after_update ('index'), after_restore ('edit')
- default_checked (false), origin ('system')
- order (0), status (true), timestamps, softDeletes

#### module_fields (30 campos)
- id, module_id (FK→modules), main (false), is_custom (false), icon (nullable)
- name, label, type (50), length (nullable), precision (nullable)
- default (nullable), nullable (false), required (false), unique (false), index (false)
- unique_table (nullable), unique_column (nullable)
- fk_table (nullable), fk_column (nullable), fk_label (nullable)
- auto_from (nullable), auto_type (nullable)
- min (nullable), max (nullable)
- order (0), status (true), origin ('system'), timestamps, softDeletes

#### module_fields_ui (33 campos)
- id, module_field_id (FK→module_fields)
- component (50), options (JSON nullable), placeholder (nullable), mask (nullable), icon (nullable), tooltip (nullable), tooltip_direction ('top')
- grid_col ('col-md-12'), form_order (0)
- visible_index (false), visible_show (false), visible_create (true), visible_edit (true)
- grid_label (nullable), width_index (nullable), grid_order (0), sortable (false), searchable (false), grid_sticky (nullable)
- grid_template (nullable), grid_link (nullable), grid_format (nullable), grid_align ('left'), grid_max_chars (nullable), grid_as_image (false), grid_image_size (32)
- grid_actions (JSON nullable)
- order (0), status (true), origin ('system'), timestamps, softDeletes

#### module_submodules (7 campos)
- id, module_id (FK→modules), submodule_id (FK→modules), order, status, timestamps, softDeletes

#### module_seeds (8 campos)
- id, module_id (FK→modules), data (JSON), order, status, origin ('system'), timestamps, softDeletes

#### module_actions (15 campos)
- id, name, slug (unique), icon (nullable), color ('btn-light'), method ('GET'), route_suffix (nullable)
- confirmation (false), confirmation_message (nullable), target ('_self'), tooltip (nullable), side ('left')
- order, status, timestamps, softDeletes

#### module_action_pivot (7 campos)
- id, module_id (FK→modules), module_action_id (FK→module_actions)
- order, status, timestamps, softDeletes
- Unique: [module_id, module_action_id]

### 4.2 Tabelas Core (3 tabelas)

#### people (7 campos)
- id, first_name, surname, order, status, timestamps, softDeletes

#### users (8 campos)
- id, person_id (FK→people, cascadeOnDelete), email (unique), password, order, status, timestamps, softDeletes

#### personal_access_tokens (9 campos)
- id, tokenable_type, tokenable_id, name, token (64, unique), abilities (nullable), last_used_at (nullable), expires_at (nullable), timestamps

### 4.3 Tabelas Laravel (2 tabelas)

- cache (key, value, expiration)
- jobs (id, queue, payload, attempts, etc.)

---

## 5. Padrões de Desenvolvimento

### 5.1 Colunas Padrão em Tabelas

Todas as tabelas têm: `id`, `order`, `status`, `created_at`, `updated_at`, `deleted_at` (soft delete)

### 5.2 Gravação sem Máscara

Campos com máscara são gravados **apenas com números** no banco:
- Telefone: `12997698040` (não `(12) 99769-8040`)
- CPF: `35564485807` (não `355.644.858-07`)
- CNPJ: `12345678000199` (não `12.345.678/0001-99`)

### 5.3 Origin

Campo `origin` presente em modules, module_fields, module_fields_ui, module_seeds:
- `system` — criado pelo sistema (não editável pelo tenant)
- `custom` — criado pelo usuário

---

## 6. O Que Já Foi Construído

### 6.1 Migrations (12 arquivos)

| # | Arquivo | Tabela |
|---|---------|--------|
| — | 0001_01_01_000001_create_cache_table | cache |
| — | 0001_01_01_000002_create_jobs_table | jobs |
| 1 | 2026_02_23_000001_create_modules_table | modules |
| 2 | 2026_02_23_000002_create_module_fields_table | module_fields |
| 3 | 2026_02_23_000003_create_module_fields_ui_table | module_fields_ui |
| 4 | 2026_02_23_000004_create_module_submodules_table | module_submodules |
| 5 | 2026_02_23_000005_create_module_seeds_table | module_seeds |
| 6 | 2026_02_23_000006_create_module_actions_table | module_actions |
| 7 | 2026_02_23_000007_create_module_action_pivot_table | module_action_pivot |
| 8 | 2026_02_23_000008_create_people_table | people |
| 9 | 2026_02_23_000009_create_users_table | users |
| 10 | 2026_02_23_000010_create_personal_access_tokens_table | personal_access_tokens |

### 6.2 Seeders (1 arquivo)

- `database/seeders/TwoClicksSeeder.php` — Cria pessoa (Alex Bethel) + usuário (alex@twoclicks.com / 12345678)

### 6.3 Comandos Artisan (1 arquivo)

- `app/Console/Commands/TwoClicksReset.php` — `php artisan twoclicks:reset --force` (migrate:fresh + TwoClicksSeeder)

### 6.4 Configurações

- `config/database.php` — Conexão `global` adicionada (PostgreSQL, banco tc_main)
- `.env` — DB_CONNECTION=global, DB_DATABASE=tc_main, DB_PASSWORD=Millena2012@

---

## 7. Dados de Seed

### TwoClicksSeeder

| Tabela | Registro |
|--------|----------|
| people | Alex Bethel (id=1) |
| users | alex@twoclicks.com / Alex1985@ (person_id=1) |

---

## 8. Próximos Passos

- [ ] Seeder de module_actions (6 ações padrão)
- [ ] Models (Eloquent)
- [ ] Sistema de autenticação
- [ ] Painel de Gerenciamento de Módulos (Fase 14)
- [ ] Sistema modular dinâmico (DynamicModel, DynamicService, DynamicController)
- [ ] Migrar arquitetura SmartClick360 para TwoClicks
