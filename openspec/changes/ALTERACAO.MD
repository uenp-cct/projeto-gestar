# Descrição Pixel Perfect — Página de Atendimento

Este documento descreve a interface da imagem como referência para implementação em uma IDE.

A tela é um dashboard web desktop de um sistema de saúde/SUS, com visual limpo, institucional e moderno. Possui sidebar fixa à esquerda, topbar azul escura no topo e área principal com formulário dividido em cards.

---

## 1. Visão geral

A tela tem proporção visual **16:9**.

Dimensão base sugerida: `2048px × 1152px`.

A estrutura geral é:

┌──────────────────────┬───────────────────────────────────────────────┐
│ Sidebar esquerda     │ Topbar azul escura                            │
│ fixa                 ├───────────────────────────────────────────────┤
│                      │ Área principal com título, botões e cards      │
└──────────────────────┴───────────────────────────────────────────────┘

---

## 2. Layout base

.app {
  display: grid;
  grid-template-columns: 270px 1fr;
  grid-template-rows: 70px 1fr;
  min-height: 100vh;
  background: #FAFBFD;
  font-family: Inter, Roboto, Arial, sans-serif;
}

.sidebar {
  grid-row: 1 / span 2;
  background: #FFFFFF;
  border-right: 1px solid #E5EAF2;
}

.topbar {
  grid-column: 2;
  height: 70px;
  background: #002F66;
}

.main {
  grid-column: 2;
  background: #FAFBFD;
  padding: 28px 24px 18px;
}

---

## 3. Paleta de cores

:root {
  --primary-blue: #0B5ED7;
  --dark-blue: #002F66;
  --topbar-blue: #003B7A;
  --title-blue: #0B1F3A;
  --card-title-blue: #0B3A75;

  --background: #FAFBFD;
  --sidebar-bg: #FFFFFF;
  --card-bg: #FFFFFF;

  --border: #E1E7EF;
  --border-light: #E5EAF2;

  --sidebar-active-bg: #EEF4FF;

  --text: #1D3557;
  --muted-text: #6B7280;
  --placeholder: #9CA3AF;

  --green-chart: #16A34A;
  --red-badge: #EF4444;
}

---

## 4. Tipografia

A fonte deve ser uma sans-serif moderna, limpa e institucional.

body {
  font-family: Inter, Roboto, Arial, sans-serif;
  color: #1D3557;
}

.page-title {
  font-size: 28px;
  font-weight: 700;
  color: #0B1F3A;
}

.card-title {
  font-size: 16px;
  font-weight: 700;
  color: #0B3A75;
}

.label {
  font-size: 12px;
  font-weight: 600;
  color: #1D3557;
}

.input,
.select,
.textarea {
  font-size: 12px;
  color: #1D3557;
}

.menu-item {
  font-size: 15px;
}

.breadcrumb {
  font-size: 13px;
}

.footer-info {
  font-size: 11px;
  color: #6B7280;
}

---

## 5. Sidebar esquerda

A sidebar ocupa toda a altura da tela.

Largura aproximada: `270px`.

Fundo: `#FFFFFF`.

Borda direita: `1px solid #E5EAF2`.

---

## 6. Cabeçalho da sidebar

No topo da sidebar há uma área de logo com altura igual à topbar.

Altura: `70px`.

Elementos visuais:

☰   [ícone coração azul] SUS  SAÚDE

Características:

.sidebar-header {
  height: 70px;
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 0 18px;
  border-bottom: 1px solid #E5EAF2;
}

O logo tem:

- ícone de coração/saúde azul;
- texto `SUS` em azul forte;
- texto `SAÚDE` menor, também azul.

---

## 7. Menu lateral

Itens do menu na ordem:

Atendimentos
Pacientes
Agenda
Relatórios
Cadastros
Protocolos
Indicadores
Configurações

No rodapé:

Ajuda

Cada item possui um ícone à esquerda e o texto à direita.

Estilo geral:

.sidebar-menu {
  padding: 24px 16px;
}

.menu-item {
  height: 48px;
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 0 14px;
  color: #1D3557;
  border-radius: 8px;
  margin-bottom: 12px;
}

O item ativo é:

Atendimentos

Estilo do item ativo:

.menu-item.active {
  background: #EEF4FF;
  color: #0B5ED7;
}

O item `Ajuda` fica próximo ao canto inferior esquerdo da sidebar.

---

## 8. Topbar superior

A topbar ocupa o topo da área principal.

Altura: `70px`.

Fundo: `#002F66`.

Elementos da esquerda para a direita:

☰        [Buscar paciente (nome, SUS...)]     🔔 3     Avatar     Gestor(a)
                                                            Unidade Básica     ˅

---

## 9. Campo de busca da topbar

Placeholder:

Buscar paciente (nome, SUS...)

Estilo:

.search-box {
  width: 410px;
  height: 36px;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.18);
  color: #FFFFFF;
  display: flex;
  align-items: center;
  padding: 0 16px;
}

O campo fica mais à direita do centro da topbar.

Há ícone de lupa no lado direito do input.

---

## 10. Notificação e perfil

Ícone de sino com badge vermelho contendo:

3

Badge:

.notification-badge {
  width: 18px;
  height: 18px;
  background: #EF4444;
  color: #FFFFFF;
  border-radius: 50%;
  font-size: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
}

Perfil do usuário:

Gestor(a)
Unidade Básica

Possui:

- avatar circular claro;
- texto branco;
- seta para baixo à direita.

---

## 11. Cabeçalho da página

Na área principal, abaixo da topbar, há título, breadcrumb e botões.

Título:

Página de atendimento

Estilo:

.page-title {
  font-size: 28px;
  font-weight: 700;
  color: #0B1F3A;
  margin-bottom: 8px;
}

Breadcrumb:

Atendimentos > Novo atendimento

- `Atendimentos` em azul;
- `Novo atendimento` em cinza.

Botões à direita:

Cancelar
Salvar rascunho
Salvar

CSS:

.header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 22px;
}

.actions {
  display: flex;
  gap: 12px;
}

.button {
  height: 44px;
  padding: 0 28px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 14px;
}

.button.cancel {
  background: #FFFFFF;
  border: 1px solid #E1E7EF;
  color: #1D3557;
}

.button.draft {
  background: #FFFFFF;
  border: 1px solid #0B5ED7;
  color: #0B5ED7;
}

.button.save {
  background: #0B5ED7;
  border: none;
  color: #FFFFFF;
}

---

## 12. Grid dos cards

A tela possui **11 cards**.

Use grid de 12 colunas:

.form-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 14px;
}

Distribuição sugerida:

.identificacao { grid-column: span 3; }
.antecedentes { grid-column: span 3; }
.habitos { grid-column: span 2; }
.situacao { grid-column: span 2; }
.risco { grid-column: span 2; }

.vacinas { grid-column: span 3; }
.exames { grid-column: span 4; }
.exame-fisico { grid-column: span 3; }

.dados-parto { grid-column: span 5; }
.anotacoes { grid-column: span 4; }
.grafico { grid-column: span 3; }

---

## 13. Estilo padrão dos cards

Todos os cards têm:

.card {
  background: #FFFFFF;
  border: 1px solid #E1E7EF;
  border-radius: 12px;
  padding: 18px 20px;
  box-shadow: none;
}

.card-title {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #0B3A75;
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 18px;
}

.card-icon {
  color: #0B5ED7;
}

Campos:

.field {
  margin-bottom: 10px;
}

.label {
  display: block;
  margin-bottom: 6px;
  color: #1D3557;
  font-size: 12px;
  font-weight: 600;
}

.input,
.select,
.textarea {
  width: 100%;
  border: 1px solid #E1E7EF;
  border-radius: 6px;
  background: #FFFFFF;
  color: #1D3557;
  font-size: 12px;
}

.input,
.select {
  height: 34px;
  padding: 0 10px;
}

.textarea {
  min-height: 70px;
  padding: 10px;
  resize: none;
}

.input::placeholder,
.textarea::placeholder {
  color: #9CA3AF;
}

---

# 14. Primeira linha de cards

A primeira linha possui cinco cards:

1. Identificação
2. Antecedentes
3. Hábitos de vida
4. Situação atual
5. Estratificação de risco

---

## 14.1 Card 1 — Identificação

Título:

1. Identificação

Ícone:

usuário/pessoa em azul

Campos:

Nome
[Digite o nome do paciente]

SUS
[000 0000 0000 0000]

Gestor
[Selecione o gestor ▼]

Médico
[Selecione o médico ▼]

Estrutura:

<section class="card identificacao">
  <h2 class="card-title">1. Identificação</h2>

  <div class="field">
    <label>Nome</label>
    <input placeholder="Digite o nome do paciente" />
  </div>

  <div class="field">
    <label>SUS</label>
    <input placeholder="000 0000 0000 0000" />
  </div>

  <div class="field">
    <label>Gestor</label>
    <select>
      <option>Selecione o gestor</option>
    </select>
  </div>

  <div class="field">
    <label>Médico</label>
    <select>
      <option>Selecione o médico</option>
    </select>
  </div>
</section>

---

## 14.2 Card 2 — Antecedentes

Título:

2. Antecedentes

Campos:

Ant. pessoais
[Descreva os antecedentes pessoais]

Ant. familiares
[Descreva os antecedentes familiares]

Ant. ginecol.
[Descreva os antecedentes ginecológicos]

Ant. obstétricos
[Descreva os antecedentes obstétricos]

As textareas são baixas, com aproximadamente `36px` a `42px` de altura.

.antecedentes textarea {
  min-height: 36px;
}

---

## 14.3 Card 3 — Hábitos de vida

Título:

3. Hábitos de vida

Conteúdo:

Tabagismo
[Não] [Sim] [Ex-tabagista]

Álcool
[Não] [Sim] [Socialmente]

Botões segmentados:

.segmented-control {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  border: 1px solid #E1E7EF;
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 24px;
}

.segmented-control button {
  height: 42px;
  background: #FFFFFF;
  border: none;
  border-right: 1px solid #E1E7EF;
  font-size: 12px;
  font-weight: 600;
  color: #1D3557;
}

.segmented-control button:last-child {
  border-right: none;
}

---

## 14.4 Card 4 — Situação atual

Título:

4. Situação atual

Campo:

[Descreva a situação atual do paciente]

Textarea grande:

.situacao textarea {
  min-height: 170px;
}

---

## 14.5 Card 5 — Estratificação de risco

Título:

5. Estratificação de risco

Opções:

○ Habitual
  Risco habitual

○ Intermediário
  Risco intermediário

○ Alto risco
  Alto risco

Cada opção fica dentro de uma caixa arredondada.

.risk-option {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  border: 1px solid #E1E7EF;
  border-radius: 8px;
  padding: 14px;
  margin-bottom: 12px;
}

.risk-title {
  font-size: 14px;
  font-weight: 700;
  color: #1D3557;
}

.risk-subtitle {
  font-size: 12px;
  color: #6B7280;
}

---

# 15. Segunda linha de cards

A segunda linha contém:

6. Vacinas
7. Exames lab e imagens
8. Exame físico

---

## 15.1 Card 6 — Vacinas

Título:

6. Vacinas

Itens:

☐ Hepatite B        [Pendente ▼]
☐ Influenza        [Pendente ▼]
☐ dTpa             [Pendente ▼]
☐ Covid-19         [Pendente ▼]
☐ Outras           [Pendente ▼]

Abaixo:

Observações
[Observações sobre vacinas]

Layout:

.vaccine-row {
  display: grid;
  grid-template-columns: 24px 1fr 120px;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
}

.vaccine-row select {
  height: 30px;
}

---

## 15.2 Card 7 — Exames lab e imagens

Título:

7. Exames lab e imagens

Este card é mais largo e dividido em duas áreas:

1. tabela de exames por trimestre;
2. área de referência de resultados.

Cabeçalho:

Exame        1º Trimestre   2º Trimestre   3º Trimestre

Linhas:

Hemograma          ☐              ☐              ☐
Glicemia           ☐              ☐              ☐
Urina (EAS)        ☐              ☐              ☐
VDRL               ☐              ☐              ☐
HIV                ☐              ☐              ☐
Ultrassonografia   ☐              ☐              ☐

Área de referência:

Referência de resultados
[Informe os resultados ou
anexos dos exames]

CSS:

.exames-content {
  display: grid;
  grid-template-columns: 1fr 170px;
  gap: 18px;
}

.exam-table {
  width: 100%;
  border-collapse: collapse;
}

.exam-table th,
.exam-table td {
  font-size: 12px;
  padding: 5px 4px;
  text-align: left;
}

.exam-table th:not(:first-child),
.exam-table td:not(:first-child) {
  text-align: center;
}

.result-reference textarea {
  min-height: 125px;
}

---

## 15.3 Card 8 — Exame físico

Título:

8. Exame físico

Campos superiores:

PA (mmHg)
[Ex.: 120/80]

AU (cm)
[Ex.: 24]

Edema
[Selecione ▼]

Abaixo:

Observações
[Observações do exame físico]

CSS:

.exam-fields {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 14px;
  margin-bottom: 16px;
}

.exame-fisico textarea {
  min-height: 70px;
}

---

# 16. Terceira linha de cards

A terceira linha contém:

9. Dados do parto e RN
10. Anotações do gestor
11. Gráfico

---

## 16.1 Card 9 — Dados do parto e RN

Título:

9. Dados do parto e RN

Primeira linha:

Data do parto
[dd/mm/aaaa 📅]

Tipo de parto
[Selecione ▼]

Local do parto
[Digite o local]

Segunda linha:

Sexo do RN
[Selecione ▼]

Peso (g)
[Ex.: 3200]

Apgar 1º min
[Ex.: 8]

Apgar 5º min
[Ex.: 9]

Abaixo:

Observações
[Observações sobre o parto e o RN]

CSS:

.birth-row-1 {
  display: grid;
  grid-template-columns: 1fr 1fr 1.3fr;
  gap: 14px;
}

.birth-row-2 {
  display: grid;
  grid-template-columns: 1fr 0.7fr 0.8fr 0.8fr;
  gap: 14px;
  margin-top: 12px;
}

---

## 16.2 Card 10 — Anotações do gestor

Título:

10. Anotações do gestor

Linhas:

☐ Consulta
[Descrever consulta realizada]

☐ Visita domiciliar
[Descrever visita domiciliar]

☐ Ações educativas
[Descrever ações educativas]

☐ Plano de cuidado
[Descrever plano de cuidado]

CSS:

.manager-note-row {
  display: grid;
  grid-template-columns: 24px 150px 1fr;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

---

## 16.3 Card 11 — Gráfico

Título:

11. Gráfico

Conteúdo interno:

Evolução do PA (mmHg)

Eixo Y:

180
140
100
60

Eixo X:

01/05
15/05
29/05
12/06
26/06

Linhas:

Linha azul: Sistólica
Linha verde: Diastólica

Legenda:

◆ Sistólica      ◆ Diastólica

Dados aproximados:

const chartData = [
  { data: "01/05", sistolica: 135, diastolica: 90 },
  { data: "15/05", sistolica: 145, diastolica: 100 },
  { data: "29/05", sistolica: 140, diastolica: 95 },
  { data: "05/06", sistolica: 155, diastolica: 100 },
  { data: "12/06", sistolica: 143, diastolica: 103 },
  { data: "19/06", sistolica: 150, diastolica: 98 },
  { data: "26/06", sistolica: 162, diastolica: 112 }
];

---

## 17. Rodapé da área principal

No canto inferior esquerdo da área principal:

Unidade: UBS Exemplo    |    Profissional: Gestor(a)    |    Data: 27/05/2025    10:30

CSS:

.footer-info {
  margin-top: 24px;
  color: #6B7280;
  font-size: 11px;
}

---

# 18. Conteúdo textual completo da tela

## Sidebar

SUS SAÚDE

Atendimentos
Pacientes
Agenda
Relatórios
Cadastros
Protocolos
Indicadores
Configurações

Ajuda

## Topbar

Buscar paciente (nome, SUS...)
3
Gestor(a)
Unidade Básica

## Cabeçalho

Página de atendimento
Atendimentos > Novo atendimento

Cancelar
Salvar rascunho
Salvar

## Cards

1. Identificação
Nome
Digite o nome do paciente
SUS
000 0000 0000 0000
Gestor
Selecione o gestor
Médico
Selecione o médico

2. Antecedentes
Ant. pessoais
Descreva os antecedentes pessoais
Ant. familiares
Descreva os antecedentes familiares
Ant. ginecol.
Descreva os antecedentes ginecológicos
Ant. obstétricos
Descreva os antecedentes obstétricos

3. Hábitos de vida
Tabagismo
Não
Sim
Ex-tabagista
Álcool
Não
Sim
Socialmente

4. Situação atual
Descreva a situação atual do paciente

5. Estratificação de risco
Habitual
Risco habitual
Intermediário
Risco intermediário
Alto risco
Alto risco

6. Vacinas
Hepatite B
Influenza
dTpa
Covid-19
Outras
Pendente
Observações
Observações sobre vacinas

7. Exames lab e imagens
Exame
1º Trimestre
2º Trimestre
3º Trimestre
Hemograma
Glicemia
Urina (EAS)
VDRL
HIV
Ultrassonografia
Referência de resultados
Informe os resultados ou anexos dos exames

8. Exame físico
PA (mmHg)
Ex.: 120/80
AU (cm)
Ex.: 24
Edema
Selecione
Observações
Observações do exame físico

9. Dados do parto e RN
Data do parto
dd/mm/aaaa
Tipo de parto
Selecione
Local do parto
Digite o local
Sexo do RN
Selecione
Peso (g)
Ex.: 3200
Apgar 1º min
Ex.: 8
Apgar 5º min
Ex.: 9
Observações
Observações sobre o parto e o RN

10. Anotações do gestor
Consulta
Descrever consulta realizada
Visita domiciliar
Descrever visita domiciliar
Ações educativas
Descrever ações educativas
Plano de cuidado
Descrever plano de cuidado

11. Gráfico
Evolução do PA (mmHg)
Sistólica
Diastólica

---

# 19. Observações de implementação

- A tela deve caber em uma viewport desktop ampla.
- O layout é denso, mas organizado.
- Os cards devem ter borda clara e cantos arredondados.
- O fundo da página é cinza quase branco.
- Os cards são brancos.
- Os títulos dos cards são azul escuro.
- Os ícones são lineares e azuis.
- O botão `Salvar` é o elemento de maior destaque.
- O item `Atendimentos` da sidebar deve estar ativo.
- A topbar deve ser azul marinho.
- O gráfico fica no canto inferior direito.
- O rodapé informativo fica pequeno e discreto no canto inferior esquerdo.
- O visual geral deve lembrar um sistema institucional de saúde pública.