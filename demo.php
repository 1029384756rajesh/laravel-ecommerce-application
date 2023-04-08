<?php 

// print_r(json_decode('[{"name":"ram"}]', true));
// echo '2' == 2;

function combineTwoArraoy($arr1, $arr2)
{
    $arr3 = [];

    foreach ($arr1 as $arr1Element) 
    {
        foreach ($arr2 as $arr2Element) 
        {
            array_push($arr3, "{$arr1Element}|{$arr2Element}");
        }
    }

    return $arr3;
}

function combineMultipleArray($arrays)
{
    for ($i=0; $i < count($arrays) - 1; $i++) 
    { 
        $arrays[$i+1] = combineTwoArraoy($arrays[$i], $arrays[$i+1]);
    }

    return $arrays[count($arrays)-1];
}

function convertStrArrayToInt($arr)
{
    $result = [];

    foreach ($arr as $element) 
    {
        array_push($result, explode("|", $element));
    }

    return $result;
}

function mapData($arr)
{
    $result = [];

    foreach ($arr as $element) 
    {
        array_push($result, [
            'price' => 0,
            'stock' => 0,
            'option_ids' => $element
        ]);
    }

    return $result;
}

function getArrayFromAtt($attributes)
{
    $outerResult = [];

    foreach ($attributes as $attribute) 
    {
        $result = [];

        foreach ($attribute['options'] as $option) 
        {
            array_push($result, $option['id']);
        }

        array_push($outerResult, $result);
    }

    return $outerResult;
}
function getArrayNamesAtt($attributes)
{
    $outerResult = [];

    foreach ($attributes as $attribute) 
    {
        $result = [];

        foreach ($attribute['options'] as $option) 
        {
            array_push($result, $option['name']);
        }

        array_push($outerResult, $result);
    }

    return $outerResult;
}

echo "<pre>";
// print_r(mapData(
//     convertStrArrayToInt(
//         combineMultipleArray([[1,2],[3,4],[5,6]])
//     ))
// );

function getOptionsFromAttribute($attribute)
{
    $result = [];

    foreach ($attribute->options as $option) 
    {
        array_push($result, $option['id']);
    }

    return $result;
}

function getArrOfOptionObj($attributes, $optionIds)
{
    $result = [];

    foreach ($attributes as $attribute) 
    {
        foreach ($attribute['options'] as $option) 
        {
            foreach ($optionIds as $optionId) {
                if($optionId == $option['id'])
                {
                    array_push($result, $option['name']);
                }
            }
        }
    }

    return implode("|", $result);
}

function mapV($variations)
{
    $result = [];

    foreach ($variations as $variation) 
    {
       array_push($result, [
        'id' => $variation['id'],
        'price' => $variation['price'],
        'stock' => $variation['stock'],
        'options' => getArrOfOptionObj([
            [
                "name" => "Size",
                "options" => [
                    [
                        "id" => 3,
                        "name" => "S"
                    ],
                    [
                        "id" => 4,
                        "name" => "M"
                    ]
                ]
            ],
            [
                "name" => "Color",
                "options" => [
                    [
                        "id" => 1,
                        "name" => "Red"
                    ],
                    [
                        "id" => 2,
                        "name" => "Blue"
                    ]
                ]
            ]
                    ], $variation['optionIds'])
       ]);
    }

    return $result;
}

// print_r(combineMultipleArray(
//     getArrayNamesAtt([
//         [
//             "name" => "Size",
//             "options" => [
//                 [
//                     "id" => 3,
//                     "name" => "S"
//                 ],
//                 [
//                     "id" => 4,
//                     "name" => "M"
//                 ]
//             ]
//         ],
//         [
//             "name" => "Color",
//             "options" => [
//                 [
//                     "id" => 1,
//                     "name" => "Red"
//                 ],
//                 [
//                     "id" => 2,
//                     "name" => "Blue"
//                 ]
//             ]
//         ]
//     ])
// ));

print_r(mapV([
    [
        "id" => 1,
        "price" => 400,
        "stock" => 50,
        "optionIds" => [
            1,
            3
        ]
]
]));