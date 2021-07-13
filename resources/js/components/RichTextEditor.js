import React, { useState, useEffect } from "react";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { Input, Label, FormGroup } from "reactstrap";
import axios from "axios";

const RichTextEditor = (props) => {
    const [checked, setchecked] = useState(false);
    const [addData, setaddData] = useState("");

    const handleChange = (e, editor) => {
        const data = editor.getData();
        setaddData(data);
        setForm({
            ...form,
            page_body: addData,
        });
    };

    const [form, setForm] = useState({
        id: props.sectionItem.id,
        section_id: props.sectionItem.section_id,
        page_name: props.sectionItem.page_name,
        page_body: props.sectionItem.page_body,
        is_publish: props.sectionItem.is_publish,
    });

    const toggle = () => {
        setchecked(!checked);
        setForm({
            ...form,
            is_publish: checked ? 0 : 1,
        });
    };
    const onSavePage = () => {
        axios
            .post("/core/helpdesk/store-page", form)
            .then((res) => {
                console.log(res.data);
            })
            .catch((err) => {
                console.log(err.data);
            });
    };
    const onDeletePage = (item) => {
        axios
            .delete("/core/helpdesk/update-sectionpage/" + item)
            .then((resp) => {
                console.log(resp.data);
            });
    };

    return (
        <div>
            <FormGroup>
                <Label for="exampleEmail">Page Title</Label>
                <Input
                    id="page_name"
                    type="text"
                    name="page_name"
                    value={form.page_name}
                    editor={ClassicEditor}
                    placeholder=""
                    onChange={(e) =>
                        setForm({
                            ...form,
                            page_name: e.currentTarget.value,
                        })
                    }
                />
            </FormGroup>
            <FormGroup>
                <Label for="exampleEmail">Page Body</Label>
                <CKEditor
                    id="page_body"
                    value={form.page_body}
                    editor={ClassicEditor}
                    data={form.page_body}
                
                    onChange={handleChange}
                />
            </FormGroup>
            <FormGroup check>
                <Label check>
                    <Input
                        onChange={toggle}
                        id="is_publish"
                        type="checkbox"
                        value={checked ? 1 : 0}
                        checked={checked}
                    />{" "}
                    is Active
                </Label>
            </FormGroup>
            <button className="btn btn-primary" onClick={onSavePage}>
                <i className="ti ti-save"></i> Save
            </button>
        </div>
    );
};

export default RichTextEditor;
