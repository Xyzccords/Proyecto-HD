import { mostrarItemDOM } from "../js/carrusel.js";
import {jest} from "@jest/globals";

describe("Carrusel - mostrarItemDOM", () => {
  test("activa solo el item indicado", () => {
    const itemsFake = [
      { classList: { add: jest.fn(), remove: jest.fn() } },
      { classList: { add: jest.fn(), remove: jest.fn() } },
      { classList: { add: jest.fn(), remove: jest.fn() } }
    ];

    mostrarItemDOM(1, itemsFake);

    expect(itemsFake[0].classList.remove).toHaveBeenCalled();
    expect(itemsFake[1].classList.add).toHaveBeenCalledWith("active");
    expect(itemsFake[2].classList.remove).toHaveBeenCalled();
  });
});