<?php
namespace ManaPHP\Authorization\Rbac;

use ManaPHP\Authorization\Rbac\Annotation\Exception;

class Annotation
{
    /**
     * @param string $className
     *
     * @return array
     * @throws \ManaPHP\Authorization\Rbac\Annotation\Exception
     */
    public function getPermissions($className)
    {
        $rc = new \ReflectionClass($className);

        $permissions = [];
        foreach ($rc->getMethods() as $method) {
            $methodName = $method->getName();

            if (preg_match('#^(.*)(Action)$#i', $methodName, $match) !== 1) {
                continue;
            }

            $action = $match[1];

            if ($match[2] !== 'Action') {
                throw new Exception('action `:action` of `:controller` is not suffix with `Action`'/**m05bcf1d580ad9945f*/,
                    ['controller' => $rc->getName(), 'action' => $methodName]);
            }

            if (!$method->isPublic()) {
                throw new Exception('action `:action` of `:controller` does not have public visibility.'/**m096584b24a62a55aa*/,
                    ['controller' => $rc->getName(), 'action' => $methodName]);
            }

            if (preg_match('#^[^/]*/([^/]*)/Controllers/(.*)Controller$#', str_replace('\\', '/', $className), $match) !== 1) {
                throw new Exception('class name is not good: :controller'/**m0356156d8fc74b80f*/, ['controller' => $rc->getName()]);
            }

            $permissions[] = [
                'module' => $match[1],
                'controller' => $match[2],
                'action' => $action,
                'description' => $match[1] . '::' . $match[2] . '::' . $action
            ];
        }

        return $permissions;
    }
}