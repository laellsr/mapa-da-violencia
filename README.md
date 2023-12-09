# Mapa da Violência

O turista pode acabar entrando ocasionalmente numa área perigosa da cidade em que está de viagem; o morador de bairro pode querer medir o índice de violência da sua região ou daquela ao qual ele está disposto a se mudar. 

O Mapa da Violência é uma aplicação voltada para a segurança pública que tem o intuito de coletar e exibir dados sobre a violência de forma geral, e exibi-los com a opção de filtrá-los por localização, tipo do crime, por data e horário; diferentemente do [Fogo Cruzado](https://fogocruzado.org.br/) que é voltado a tiroteios e do [Crime Watch Crime Map](https://play.google.com/store/apps/details?id=com.fullersoftware.crime&hl=pt_BR&gl=US) que não possui filtros temporais. 

## Problemas

1. Não ser possível prever os possíveis locais seguros de uma região sem o conhecimento do morador local.
2. Não é possível escolher o lugar mais seguro para morar pois os dados de crimes não estão facilmente acessíveis.
3. Não é possível saber quantos e quais crimes ocorreram em determinada região em determinada data de forma fácil e de visibilidade intuitiva.

## Expectativas

1. Ele(a) espera avaliar quais perigos um lugar pode apresenta e quais os piores horários do dia para tomar decisões como: não sair com joais, celular ou carteiras a vista; não sair com a família ou evitar passar no local; andar ou não com as janelas do automóvel levantas.   
2. Identificar os crimes de um local em um aplicativo de mapa.
3. Monitorar a violência de uma determinada região, filtrando os dados por tipo de crime e/ou por data.

## Personas

### Turista

O turista, quando quer conhecer um novo local, procura informações sobre ele na internet, mais precisamente numa busca pelo Google. Ele se empenha em conhecer a beleza do ambiente, a gastronomia e a cultura local junto também com as possíveis dificuldades para poder acessá-las, entre elas, a violência. 

O excesso de violência pode decidir suas ações no local, como ser muito cuidadoso com seus bens, com o horário ou até decisões extremas como evitar o acesso temendo sua própria vida. Seu sexo também vai fazer parte dessa decisão. Sair com ou sem o celular, o automóvel, as joias. Ele ou ela espera prever quais perigos um lugar pode apresentar: furtos, assaltos, sequestros e/ou estupros.

### Morador local

O morador local tem expectativas de morar em outro bairro, porém, ele não gostaria de se mudar para uma região mais perigosa da qual ele reside. Os dados que ele busca analisar não estão facilmente disponíveis em uma pesquisa simples no Google. Usando as palavras chaves “violência no bairro x”, onde x é o bairro da expectativa, aparece apenas notícias relacionadas a crimes no bairro e, apenas por isso, não é possível constatar ou medir a violência. Ele busca visualizar os dados de uma maneira mais fácil e de costume, como a apresentação do Google Maps, e deseja que as informações estejam atualizadas para poder realizar o comparativo e tomar sua decisão.

## Marcos

### Marco 1 - Design - Figma 18/12/23

Fase de prototipagem: demonstração e mapeamento do fluxo de telas.

### Marco 2 - Apresentação do mapa  

Será apresentado o mapa com as suas principais métricas e componentes visuais.

### Funcionalidades

- [ ] Navegar pelo Mapa.
- [ ] Realizar Denúncias
- [ ] Marcadores Visuais no Mapa dos Tipos Diferentes de Crimes.
- [ ] Popup com as estatísticas da região

### Marco 3 - Descrição das Denúncias Realizadas  

Mostrar as informações: Tipo do crime, dia e horário da ocorrência, localidade, dados adicionais do ocorrido

### Funcionalidades

- [ ] Lista de Crimes Linkados ao Mapa.
      
### Marco 4 - Login, Cadastro

Será efetuado a parte de acesso ao sistema do usuário bem como as ações de mitigação aos riscos enumerados.

### Funcionalidades

- [ ] Sistema de Cadastro.
- [ ]  Limite de dois relatos por mês.

## Riscos

1. **Risco 1** Propagação de denúncias falsas. Um usuário mal intencionado ou não, pode destruir a reputação de algum local ou região, criando assim denúncias falsas.
    
    **Severidade Alta e Probabilidade Alta.**
    
    Ações para mitigação do risco:
    
    - Um CPF por cadastro diminui a possibilidade que ele tem de criar usuários falsos com esse fim.
    - Limitar os relatos a dois por mês, impede que o usuário inunde o sistema.

## Componentes

### Aplicativo Web

[descrição breve]
[https://github.com/edgebr/templates-artefatos](https://github.com/edgebr/templates-artefatos)

## Stakeholders

- Cidadãos em Geral;
- Governos Locais;
- Turistas de outras cidades, estados, países;
- Empresas de Hotelaria e Turismo.

## Equipe

Gustavo Cavalcante Costa
[gcco@ic.ufal.br](mailto:gcco@ic.ufal.br)

Julius Martins Lira de Albuquerque
[jmla@ic.ufal.br](mailto:jmla@ic.ufal.br)

Lael de Lima Santa Rosa
[llsr@ic.ufal.br](mailto:llsr@ic.ufal.br)

Matheus Feitosa Ramos
[mfr@ic.ufal.br](mailto:mfr@ic.ufal.br)

Victor Ferro Sousa Monteiro
[vfsm@ic.ufal.br](mailto:vfsm@ic.ufal.br)

## Status Reports

[Status Report 1 (20/12/2022)](https://www.notion.so/status_report_1.md)
