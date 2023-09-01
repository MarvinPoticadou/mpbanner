import Grid from '@components/grid/grid';
import LinkRowActionExtension from '@components/grid/extension/link-row-action-extension';
import SubmitRowActionExtension from '@components/grid/extension/action/row/submit-row-action-extension';
import SortingExtension from "@components/grid/extension/sorting-extension";
import ColumnTogglingExtension from "@components/grid/extension/column-toggling-extension";

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.js-grid').forEach(gridDiv => {
    const grid = new Grid(gridDiv.dataset.gridId);

    grid.addExtension(new LinkRowActionExtension());
    grid.addExtension(new SortingExtension());
    grid.addExtension(new SubmitRowActionExtension());
    grid.addExtension(new ColumnTogglingExtension());
  });
});
