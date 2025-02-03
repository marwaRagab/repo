<div class="card">
    <h4 class="card-title mb-3">تعديل مجموعة عمل</h4>
    <div class="card-body">
        @include('role.form', ['formAction' => route('roles.update', $role->id), 'role' => $role])
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Expand/Collapse Functionality
        document.querySelectorAll(".tree input[type='checkbox']").forEach(checkbox => {
            if (checkbox.checked) {
                let parentUl = checkbox.closest("ul.child-tree");
                if (parentUl) {
                    parentUl.style.display = "block";
                    let parentLi = parentUl.closest("li");
                    if (parentLi) {
                        parentLi.classList.add("open");
                    }
                }
            }
        });
        document.querySelectorAll(".toggle-arrow").forEach(arrow => {
            arrow.addEventListener("click", function () {
                let parentLi = this.closest("li");
                let childUl = parentLi.querySelector("ul.child-tree");

                if (childUl) {
                    let isVisible = childUl.style.display === "block";
                    childUl.style.display = isVisible ? "none" : "block";
                    parentLi.classList.toggle("open", !isVisible);
                }
            });
        });

        // Parent Checkbox Controls Children Without Infinite Loop
        document.querySelectorAll(".parent-checkbox").forEach(parentCheckbox => {
            parentCheckbox.addEventListener("change", function (event) {
                let isChecked = this.checked;
                let parentLi = this.closest("li");
                let childCheckboxes = parentLi.querySelectorAll("ul.child-tree input[type='checkbox']");

                childCheckboxes.forEach(childCheckbox => {
                    if (childCheckbox.checked !== isChecked) {
                        childCheckbox.checked = isChecked;
                        childCheckbox.dispatchEvent(new Event("change", { bubbles: false })); // Prevents event bubbling
                    }
                });
            });
        });

        // Child Checkbox Updates Parent Without Infinite Loop
        document.querySelectorAll("ul.child-tree input[type='checkbox']").forEach(childCheckbox => {
            childCheckbox.addEventListener("change", function (event) {
                let parentUl = this.closest("ul.child-tree");
                let parentLi = parentUl.closest("li");
                let parentCheckbox = parentLi.querySelector(".parent-checkbox");

                if (parentCheckbox) {
                    let childCheckboxes = parentUl.querySelectorAll("input[type='checkbox']");
                    let checkedChildren = parentUl.querySelectorAll("input[type='checkbox']:checked");

                    // Indeterminate if some children are checked, but not all
                    if (checkedChildren.length > 0 && checkedChildren.length < childCheckboxes.length) {
                        parentCheckbox.indeterminate = true;
                    } else {
                        parentCheckbox.indeterminate = false;
                        parentCheckbox.checked = checkedChildren.length === childCheckboxes.length;
                    }
                }
            });
        });
    });
</script>

