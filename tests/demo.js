const ids = cart.products.map(product => product.id)

const products = []

cart.products.map(cartProduct => {
    const product = products.find(product => cartProduct.id == product.id)

    if(product) {

        if(cartProduct.variationId) {

            const variation = product.variations.find(cartProduct.variationId)

            if(variation) {

            }
        }
    }

    


})

const pr = {
    id: 1029,
    name: "Mens tshirt",
    shortDescription: "Demo short description",
    longDescription: "Demo long description",
    categoryId: 1029,
    images: [
        "image1.png",
        "image2.png",
    ],
    parentId: 1029,
    attribute: [
        {
            name: "Size",
            value: "S"
        },
        {
            name: "Color",
            value: "M"
        }
    ],
    attributes: [
        {
            name: "Size",
            type: "image",
            values: [
                {
                    label: "Red",
                    code: ""
                },
                {
                    label: "Blue",
                    code: ""
                }
            ]
        },
        {
            name: "Color",
            values: ["Red","Blue","White"]
        }
    ],
    variations: [
        {
            sku: "",
            price: 400,
            stock: 900,
            images: [
                "/image-1.png",
                "/image-2.png"
            ],
            optionIds: [
                "1029",
                "1029",
            ]
        },
        {
            sku: "",
            price: 400,
            stock: 900,
            images: [
                "",
                ""
            ],
            attributeId: ""
        }
    ]
}