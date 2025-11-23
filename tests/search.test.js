import { debounce } from "../js/search.js";
import {jest} from "@jest/globals";

jest.useFakeTimers();

test("debounce debe retrasar la ejecución", () => {
  const fn = jest.fn();
  const debouncedFn = debounce(fn, 200);

  debouncedFn();
  debouncedFn();
  debouncedFn();

  expect(fn).not.toHaveBeenCalled();

  jest.advanceTimersByTime(200);

  expect(fn).toHaveBeenCalledTimes(1);
});
