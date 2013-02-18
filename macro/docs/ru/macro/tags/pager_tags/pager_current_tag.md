# Тег {{pager:current}}
## Описание
**{{pager:current}}** позволяет вывести ссылку на текущую страницу (или просто ее номер) в pager-е.

Вставляет следующие переменные в шаблон:

**$href** — ссылка на страницу
**$number** — номер страницы

Например:

    {{pager:current}}<b>{$number}</b>{{/pager:current}}

## Синтаксис

    {{pager:current}}
    __some___content__
    {{/pager:current}}

## Область применения
Должен быть дочерним тегом от [тега {{pager:list}}](./pager_list_tag.md).

## Атрибуты
Нет.

## Содержимое
Оформление ссылки, где используется выражения {$href} и {$number}.

## Пример использования
см. пример к [тегу {{pager}}](./pager_tag.md).