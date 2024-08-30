<div className="card">
    <div className="card-header d-flex align-items-center gap-2 justify-content-end">
        <i class="bi bi-plus"></i>
        <i class="bi bi-list"></i>
    </div>
                                            <div className="card-body">
                                                <div className="mb-3">
                                                    <label className="form-label">Attribute <span className="text-danger">*</span></label>
                                                    <input type="text" className="form-control" name="name"/>
                                                </div>

                                                <div className="mb-3">
                                                    <label className="form-label">Type <span className="text-danger">*</span></label>
                                                    <select name="type" value={attribute.type} className="form-control form-select">
                                                        <option value="label">Label</option>
                                                        <option value="image">Image</option>
                                                        <option value="color">Color</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label className="form-label">Options <span className="text-danger">*</span></label>

                                                    <div className="d-flex flex-column gap-2">
                                                        {attribute.options.map((option, optionIndex) => (
                                                            <div className="d-flex justify-content-start align-items-center gap-2">
{/* 
                                                                {attribute.type === "image" ? (
                                                                    <label style={{ cursor: "pointer" }}>
                                                                        <img src={{ option.}} className="border rounded-1" style={{ width: 38, height: 38, objectFit: "cover", }} />
                                            

                                                                        <input type="file" className="d-none" onChange={event => changeValue(attributeIndex, valueIndex, event)} name="option" />
                                                                    </label>
                                                                ) : attribute.type === "color" ? (
                                                                    <input type="color" name="value" className="form-control form-control-color" value={value.value} onChange={event => changeValue(attributeIndex, valueIndex, event)} style={{ maxWidth: 50 }} />
                                                                ) : null}


                                                                <input type="text" className="form-control" name="label" value={value.label} onChange={event => changeValue(attributeIndex, valueIndex, event)} /> */}

<input type="text" style={{width: 100}} onChange={event=>changeOption(attributeIndex, optionIndex, event)} name="value" value={option.value}/>

<input type="text" style={{width: 100}} onChange={event => changeOption(attributeIndex, optionIndex, event)} name="name" value={option.name}/>

                                                                <div style={{ cursor: "pointer" }}>
                                                                    {optionIndex === attribute.options.length - 1 ? <MdAdd onClick={() => createOption(attributeIndex)} /> : <MdClose onClick={() => removeOption(attributeIndex, optionIndex)} />}
                                                                </div>
                                                            </div>
                                                        ))}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>