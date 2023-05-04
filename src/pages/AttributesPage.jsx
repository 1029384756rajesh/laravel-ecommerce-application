import { FaTimes } from "react-icons/fa"

export default function AttributesPage() {
    return (
        <form action="/admin/products/{{ $product->id }}/attributes" method="POST" class="card mx-auto my-4 max-w-5xl overflow-hidden">


            <div class="card-header card-header-title">Attributes</div>

            <div className="overflow-auto">
            <div class="card-body min-w-[800px]">



<div class="flex items-start gap-4 mb-5 last:mb-0 attribute">
    <input type="text" name="attributes" class="form-control w-48" value="Size" placeholder="Attribute" />

    <div class="form-control flex-1">
        <div class="mb-2 flex gap-2 flex-wrap options">
            <div class="btn btn-secondary flex items-center gap-1">
                <span>S</span>
                <FaTimes size={18} className="font-normal"/>
            </div>
            <div class="btn btn-secondary flex items-center gap-1">
                <span>M</span>
                <FaTimes size={18} className="font-normal"/>
            </div>
        </div>

        <input type="text" class="form-control border-none"/>
    </div>

    <button class="btn btn-sm btn-outline-secondary">
        <FaTimes size={18}/>
    </button>
</div>

<div class="flex items-start gap-4 mb-5 last:mb-0 attribute">
    <input type="text" name="attributes" class="form-control w-48" value="Color" placeholder="Attribute" />

    <div class="form-control flex-1">
        <div class="mb-2 flex gap-2 flex-wrap options">
            <div class="btn btn-secondary flex items-center gap-1">
                <span>Red</span>
                <FaTimes size={18} className="font-normal"/>
            </div>
            <div class="btn btn-secondary flex items-center gap-1">
                <span>Blue</span>
                <FaTimes size={18} className="font-normal"/>
            </div>
            <div class="btn btn-secondary flex items-center gap-1">
                <span>White</span>
                <FaTimes size={18} className="font-normal"/>
            </div>
        </div>

        <input type="text" class="form-control border-none" placeholder="Write options separated by comma"/>
    </div>

    <button class="btn btn-sm btn-outline-secondary">
        <FaTimes size={18}/>
    </button>
</div>
</div>
            </div>

            <div class="card-footer flex justify-end gap-2">
                <button id="btnSave" class="btn btn-primary">Save</button>
                <button id="addNew" type="button" class="btn btn-outline-secondary">Add new</button>
            </div>
        </form>
    )
}