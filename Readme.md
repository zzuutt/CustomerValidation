# Customer Validation

Give access to certain functions, when the administrator validated the account

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is CustomerValidation.
* Activate it in your thelia administration panel

### Composer

## Usage

* Edit pages that you do not want uncommitted clients to access. (see below example).
* When the client changes to status 'valid', an email is sent to the client.

## Hook

it use a standard hook.


## Loop

[customer-validation loop]

### Input arguments

|Argument |Description |
|---      |--- |
|**id** | filter by id |
|**status** | filter by status |
|**order** | order result by "id","id-reverse","status","status-reverse"  |

### Output arguments

|Variable   |Description |
|---        |--- |
|$ID    | id |
|$STATUS    | status   (1 -> waiting , 2 - > valid , 3 -> refuse)|

[customer-validation-status loop]

### Input arguments

|Argument |Description |
|---      |--- |
|**id** | filter by id |
|**code** | filter by status |
|**title** | filter by title |
|**order** | order result by "id","id-reverse","code","code-reverse","title","title-reverse","description","description-reverse","chapo","chapo-reverse","postscriptum","postscriptum-reverse",  |

### Output arguments

|Variable   |Description |
|---        |--- |
|$ID    | id |
|$CODE    | code |
|$TITLE    | title |
|$DESCRIPTION    | description |
|$CHAPO    | chapo |
|$POSTSCRIPTUM    | postscriptum |


### Example

```html
{loop name="customer_status" type="customer-validation" id=$customer_id}
    {if $STATUS == 2}
    ...
    {else}
    <div class="alert alert-warning" role="alert">{intl l='Your account is awaiting validation. You can not access this resource.'}</div>
    {/if}
{/loop}
```
