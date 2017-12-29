# Command Bus

### Define a simple command

1. Create new class extends from `go1\command\Command`

```php
namespace dev;

use go1\command\Command;

class CommandFoo extends Command 
{
    # Inject dependencices
    public function __constructor() 
    {
    }
    
    public function execute()
    {
        $payload = $this->getPayload();
        // Do your bussiness
    }
} 

``` 

2. Run `CommandFoo` via `CommandBus`

```php
namespace devel;

use go1\command\CommandBus;

$commandFoo = new CommandFoo();
$commandFoo->setPayload($data = 'your data');

$commandBus = new CommandBus();
$commandBus->execute($commandFoo);

```

### Define a command with handler
If your logic quite complex and you want to move it to a handler service, you can create new handler class and attach to command bus.

Note: CommandBus auto maps your command & handler. Following naming pattern, if command is `CommandFoo`, handler must be `CommandFooHandler` 

1. Create new class extends from `go1\command\Command`
 
 ```php
 namespace dev;
 
 use go1\command\Command;
 
 class CommandFoo extends Command 
 {
     # Now command only contains data
 } 
 
 ``` 
 
2. Create new class implements from `go1\command\CommandHandlerInterface`
 
 ```php
  namespace dev;
  
  use go1\command\CommandHandlerInterface;
  
  class CommandFooHandler implements CommandHandlerInterface 
  {
      # Inject dependencices
      public function __constructor() 
      {
      }
      
      public function handle(CommandInterface $command) 
      {
        # Do your bussiness here
      }
  } 
  
  ```
  
3. Run command via CommandBus

```php
namespace devel;

use go1\command\CommandBus;
use go1\command\CommandFooHandler;
use go1\command\CommandFoo;

$commandFoo = new CommandFoo();
$commandFoo->setPayload($data = 'your data');

$commandFooHandler = new CommandFooHandler();

$commandBus = new CommandBus([$commandFooHandler]);
$commandBus->execute($commandFoo);

```

### Attach middleware to CommandBus

1. Create new class implements from `go1\command\CommandMiddlewareInterface`

```php
namespace dev;
  
use go1\command\CommandMiddlewareInterface;

class CommandFooHandler implements CommandMiddlewareInterface 
{
    # Inject dependencices
    public function __constructor() 
    {
    }
    
    public function invoke(CommandInterface $command) 
    {
        # Do your bussiness here
        
        # If you can interrups command by:
        $command->stopPropagation();     
    }
  
}  
```

2. Attach middleware to CommandBus

```php
namespace devel;

use go1\command\CommandBus;
use go1\command\CommandFooHandler;
use go1\command\CommandFoo;

$commandFoo = new CommandFoo();
$commandFoo->setPayload($data = 'your data');

$commandFooHandler = new CommandFooHandler();
$commandFooMiddleware = new CommandFooMiddleware()

$commandBus = new CommandBus([$commandFooHandler], [$commandFooMiddleware]);
$commandBus->execute($commandFoo);

``` 
