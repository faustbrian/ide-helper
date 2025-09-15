<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\IdeHelper;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contract\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;
use Override;
use Spatie\ModelInfo\ModelInfo;

use function implode;
use function is_subclass_of;

// use Monolith\SharedKernel\Infrastructure\Data\AbstractDataTransferObject;

/**
 * @author Brian Faust <brian@cline.sh>
 *
 * @version 1.0.0
 */
final class DataCastHook implements ModelHookInterface
{
    #[Override()]
    public function run(ModelsCommand $command, Model $model): void
    {
        $modelInfo = ModelInfo::forModel($model);

        foreach ($modelInfo->attributes as $attribute) {
            // if ($attribute->cast === null || !is_subclass_of($attribute->cast, AbstractDataTransferObject::class)) {
            //     continue;
            // }

            $types = ['\\'.$attribute->cast];

            if ($attribute->nullable) {
                $types[] = 'null';
            }

            $command->setProperty($attribute->name, implode('|', $types));
        }
    }
}
