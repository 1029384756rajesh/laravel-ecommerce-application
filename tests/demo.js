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