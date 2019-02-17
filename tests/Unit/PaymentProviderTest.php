<?php

namespace Tests\Unit;

use App\Http\Resources\PaymentProvider;
use Illuminate\Http\Request;
use Tests\TestCase;

class PaymentProviderTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_should_convert_model_into_array()
    {
        $modelId = factory(\App\PaymentProvider::class)->create()->id;
        $model = \App\PaymentProvider::find($modelId);
        $resourceData = (new PaymentProvider($model))->toArray(new Request());
        $this->assertNotEquals($model->toArray(), $resourceData);
        $model->delete();
    }

}
