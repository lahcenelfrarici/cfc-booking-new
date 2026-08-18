<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:booking-datetime-picker */
class __TwigTemplate_803fccac7b5f220486ce344a1cc10f6b extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--booking-datetime-picker"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:booking-datetime-picker"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:booking-datetime-picker"));
        yield "<div
  data-matrix=\x27";
        // line 2
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["matrix"] ?? null));
        yield "\x27
  data-durations=\x27";
        // line 3
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["durations_json"] ?? null));
        yield "\x27
  x-data=\"{
    matrix: {},
    durations: [],
    selectedDuration: \x27";
        // line 7
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["default_duration"] ?? null), "html", null, true);
        yield "\x27,
    selectedDate: \x27\x27,
    selectedTime: \x27\x27,
    dayAvailable(iso) {
      const day = this.matrix[iso];
      if (!day) return false;
      return Object.keys(day).some((slot) => day[slot][this.selectedDuration]);
    },
    slotAvailable(slot) {
      if (!this.selectedDate) return false;
      const day = this.matrix[this.selectedDate];
      return !!(day && day[slot] && day[slot][this.selectedDuration]);
    },
    pickDate(iso) {
      if (!this.dayAvailable(iso)) return;
      this.selectedDate = iso;
      document.getElementById(\x27";
        // line 23
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["date_field_id"] ?? null), "html", null, true);
        yield "\x27).value = iso;
      if (this.selectedTime && !this.slotAvailable(this.selectedTime)) {
        this.selectedTime = \x27\x27;
        document.getElementById(\x27";
        // line 26
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time_field_id"] ?? null), "html", null, true);
        yield "\x27).value = \x27\x27;
      }
    },
    pickTime(slot) {
      if (!this.slotAvailable(slot)) return;
      this.selectedTime = slot;
      document.getElementById(\x27";
        // line 32
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time_field_id"] ?? null), "html", null, true);
        yield "\x27).value = slot;
    },
    pickDuration(d) {
      this.selectedDuration = d;
      document.getElementById(\x27";
        // line 36
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["duration_field_id"] ?? null), "html", null, true);
        yield "\x27).value = d;
      if (this.selectedDate && !this.dayAvailable(this.selectedDate)) {
        this.selectedDate = \x27\x27;
        document.getElementById(\x27";
        // line 39
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["date_field_id"] ?? null), "html", null, true);
        yield "\x27).value = \x27\x27;
      }
      if (this.selectedTime && !this.slotAvailable(this.selectedTime)) {
        this.selectedTime = \x27\x27;
        document.getElementById(\x27";
        // line 43
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time_field_id"] ?? null), "html", null, true);
        yield "\x27).value = \x27\x27;
      }
    },
  }\"
  x-init=\"matrix = JSON.parse(\$el.dataset.matrix); durations = JSON.parse(\$el.dataset.durations);\"
>
  ";
        // line 49
        if ( !(($tmp = ($context["has_space"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 50
            yield "    <p class=\"text-neutral-500 text-[14px] bg-neutral-50 border border-neutral-100 rounded-2xl px-5 py-4\">
      Select a space above to see available dates.
    </p>
  ";
        } else {
            // line 54
            yield "    <div class=\"text-[12px] uppercase tracking-wide text-neutral-500 mb-4 font-semibold\">Choose a date</div>
    <div class=\"grid grid-cols-7 gap-2.5\">
      ";
            // line 56
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["days"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
                // line 57
                yield "        <button
          type=\"button\"
          x-on:click=\"pickDate(\x27";
                // line 59
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 59), "html", null, true);
                yield "\x27)\"
          x-bind:disabled=\"!dayAvailable(\x27";
                // line 60
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 60), "html", null, true);
                yield "\x27)\"
          x-bind:class=\"{
            \x27opacity-30 cursor-not-allowed border-neutral-100 bg-neutral-50\x27: !dayAvailable(\x27";
                // line 62
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 62), "html", null, true);
                yield "\x27),
            \x27bg-[#9F5434] border-[#9F5434] text-white shadow-[0_8px_20px_-8px_rgba(159,84,52,0.4)]\x27: selectedDate === \x27";
                // line 63
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 63), "html", null, true);
                yield "\x27,
            \x27border-neutral-200 bg-white hover:border-neutral-300\x27: dayAvailable(\x27";
                // line 64
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 64), "html", null, true);
                yield "\x27) && selectedDate !== \x27";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 64), "html", null, true);
                yield "\x27,
          }\"
          class=\"rounded-2xl p-3 text-center transition-all border\"
        >
          <div class=\"text-[11px] mb-1.5 font-medium\" x-bind:class=\"selectedDate === \x27";
                // line 68
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 68), "html", null, true);
                yield "\x27 ? \x27text-white/70\x27 : \x27text-neutral-400\x27\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "weekday", [], "any", false, false, true, 68), "html", null, true);
                yield "</div>
          <div class=\"text-[16px] font-bold\" x-bind:class=\"selectedDate === \x27";
                // line 69
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 69), "html", null, true);
                yield "\x27 ? \x27text-white\x27 : \x27text-neutral-900\x27\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "day", [], "any", false, false, true, 69), "html", null, true);
                yield "</div>
          <div class=\"text-[11px] mt-0.5\" x-bind:class=\"selectedDate === \x27";
                // line 70
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 70), "html", null, true);
                yield "\x27 ? \x27text-white/60\x27 : \x27text-neutral-400\x27\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "month", [], "any", false, false, true, 70), "html", null, true);
                yield "</div>
          <div
            class=\"w-1.5 h-1.5 rounded-full mx-auto mt-2\"
            x-show=\"dayAvailable(\x27";
                // line 73
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 73), "html", null, true);
                yield "\x27)\"
            x-bind:class=\"selectedDate === \x27";
                // line 74
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["d"], "iso", [], "any", false, false, true, 74), "html", null, true);
                yield "\x27 ? \x27bg-white/60\x27 : \x27bg-emerald-400\x27\"
          ></div>
        </button>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['d'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 78
            yield "    </div>

    <div class=\"mt-6 flex items-center gap-5 text-[12px] text-neutral-400\">
      <span class=\"flex items-center gap-1.5\"><span class=\"w-2 h-2 rounded-full bg-emerald-400 inline-block\"></span> Available</span>
      <span class=\"flex items-center gap-1.5\"><span class=\"w-2 h-2 rounded-full bg-neutral-200 inline-block\"></span> Unavailable</span>
    </div>

    <div x-show=\"selectedDate\" x-cloak class=\"mt-8\">
      <div class=\"text-[12px] uppercase tracking-wide text-neutral-500 mb-4 font-semibold\">Available slots</div>
      <div class=\"grid grid-cols-5 gap-3\">
        ";
            // line 88
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["time_slots"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["slot"]) {
                // line 89
                yield "          <button
            type=\"button\"
            x-on:click=\"pickTime(\x27";
                // line 91
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27)\"
            x-bind:disabled=\"!slotAvailable(\x27";
                // line 92
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27)\"
            x-bind:class=\"{
              \x27opacity-30 cursor-not-allowed bg-neutral-50 border-neutral-100 text-neutral-400\x27: !slotAvailable(\x27";
                // line 94
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27),
              \x27bg-[#9F5434] border-[#9F5434] text-white shadow-[0_8px_20px_-8px_rgba(159,84,52,0.35)] font-semibold\x27: selectedTime === \x27";
                // line 95
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27,
              \x27bg-white border-neutral-200 text-neutral-900 hover:border-[#9F5434]/40 hover:bg-[#9F5434]/5\x27: slotAvailable(\x27";
                // line 96
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27) && selectedTime !== \x27";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "\x27,
            }\"
            class=\"py-3 rounded-xl border text-[14px] transition-all\"
          >
            ";
                // line 100
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["slot"], "html", null, true);
                yield "
          </button>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['slot'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 103
            yield "      </div>

      <div class=\"mt-8\">
        <div class=\"text-[12px] uppercase tracking-wide text-neutral-500 mb-4 font-semibold\">Duration</div>
        <div class=\"flex gap-3 flex-wrap\">
          ";
            // line 108
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["durations"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
                // line 109
                yield "            <button
              type=\"button\"
              x-on:click=\"pickDuration(\x27";
                // line 111
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "\x27)\"
              x-bind:class=\"selectedDuration === \x27";
                // line 112
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "\x27 ? \x27bg-[#9F5434] border-[#9F5434] text-white font-semibold\x27 : \x27bg-white border-neutral-200 text-neutral-700 hover:border-neutral-400\x27\"
              class=\"px-5 py-2.5 rounded-xl border text-[13px] transition-all\"
            >
              ";
                // line 115
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
                yield "
            </button>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['d'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 118
            yield "        </div>
      </div>

      <div x-show=\"selectedTime\" x-cloak class=\"mt-6 p-5 bg-[#9F5434]/5 border border-[#9F5434]/20 rounded-2xl flex items-center gap-3\">
        ";
            // line 122
            yield from $this->load("cfc_media_hub:icon", 122)->unwrap()->yield(CoreExtension::toArray(["name" => "clock", "size" => "w-4 h-4 text-[#9F5434]"]));
            // line 123
            yield "        <span class=\"text-[14px] text-neutral-700\">
          <strong x-text=\"selectedTime\"></strong> &middot; <span x-text=\"selectedDuration\"></span>
        </span>
      </div>
    </div>
  ";
        }
        // line 129
        yield "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["matrix", "durations_json", "default_duration", "date_field_id", "time_field_id", "duration_field_id", "has_space", "days", "time_slots", "durations"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:booking-datetime-picker";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  312 => 129,  304 => 123,  302 => 122,  296 => 118,  286 => 115,  280 => 112,  276 => 111,  272 => 109,  268 => 108,  261 => 103,  251 => 100,  242 => 96,  238 => 95,  234 => 94,  229 => 92,  225 => 91,  221 => 89,  217 => 88,  205 => 78,  194 => 74,  190 => 73,  182 => 70,  176 => 69,  170 => 68,  161 => 64,  157 => 63,  153 => 62,  148 => 60,  144 => 59,  140 => 57,  136 => 56,  132 => 54,  126 => 50,  124 => 49,  115 => 43,  108 => 39,  102 => 36,  95 => 32,  86 => 26,  80 => 23,  61 => 7,  54 => 3,  50 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:booking-datetime-picker", "themes/custom/cfc_media_hub/components/booking-datetime-picker/booking-datetime-picker.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 49, "for" => 56, "include" => 122];
        static $filters = ["raw" => 2, "escape" => 7];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "if", 1 => "for", 2 => "include"],
                [0 => "raw", 1 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
