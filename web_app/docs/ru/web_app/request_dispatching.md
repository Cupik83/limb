# Разбор запроса и определение текущего контроллера и действия
## Что мы получаем из запроса?

При получении запроса система должна определить, что она должна сделать. По сути это означает, что необходимо определить на основе Запроса следующие сущности:

* **Контроллер** (page controller). Контроллер определяет как бы предметную принадлежность запроса.
* **Action** — действие, которое контролер должен выполнить. Действие конкретизирует задачу для приложения.

## Схема разбора запроса в Limb3 приложении
Если вы читали страницу [«Использование цепочки фильтров для организации Front-Controller»](./filter_chain.md), то уже знаете, что в типичном Limb3 приложении разбор запроса производится в фильтре **lmbRequestDispatchingFilter**, который получает в конструктор объект **диспатчера запросов**, реализующий интерфейс **lmbRequestDispatcher**.

Интерфейс lmbRequestDispatcher состоит из одного метода dispatch($request). Это метод должен возвращать массив параметров, доступных из Запроса.

Обычно массив этих параметров, которые возвращает диспатчер запроса выглядит следующим образом:

    $result = array('controller' => 'newsline', // Note:! under_scores for controller param
                    'action' => 'archive', 
                    'id' => 150);

Из параметров, которые вернул диспатчер запросов, фильтр lmbRequestDispatchingFilter создает объект класса lmbController при помощи метода lmbToolkit :: instance()→createController($controller_name) и ставит ему текущее действие (current action). Для этих целей фильтр использует параметры controller и action (см. пример параметров выше).

Полученный объект $dispatched_controller отдается в тулкит при помощи метода setDispatchedController($controller).

## Диспатчер запросов, используемый в WEB_APP по-умолчанию
В пакете WEB_APP доступен класс **lmbRoutesRequestDispatcher**, реализующий интерфейс lmbRequestDispatcher. Именно он используется по-умолчания как диспатчер запросов в туториалах.

lmbRoutesRequestDispatcher опирается на класс [lmbRoutes](./lmb_routes.md), который используется для получения параметров из строк исходя из определенных паттернов (идея класса [lmbRoutes](./lmb_routes.md) была взята из Ruby on Rails фреймворка, ее сейчас можно встретить в различных фреймворках, например, в Zend framework).

## Архитектура подсистемы разбора запроса
Файлы классов и интерфейсов подсистемы разбора запроса можно найти в папке **limb/web_app/src/request**

![Alt-request_dispatching](http://wiki.limb-project.com/2011.1/lib/exe/fetch.php?cache=&media=limb3:ru:packages:web_app:limb3_request_dispatch.png)

![Alt-request_dispatch_sequence](http://wiki.limb-project.com/2011.1/lib/exe/fetch.php?cache=&media=limb3:ru:packages:web_app:limb3_request_dispatch_seq.png)
